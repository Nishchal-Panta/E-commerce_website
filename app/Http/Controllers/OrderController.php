<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('buyer_id', auth()->id())
            ->with('product.images')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        $tax = $subtotal * 0.10;
        $shipping = $subtotal > 100 ? 0 : 10;
        $total = $subtotal + $tax + $shipping;

        return view('buyer.checkout', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:card,cash_on_delivery',
        ]);

        $cartItems = Cart::where('buyer_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Your cart is empty.');
        }

        // Verify stock availability
        foreach ($cartItems as $item) {
            if ($item->product->inventory_quantity < $item->quantity) {
                return back()->with('error', "Insufficient stock for {$item->product->name}");
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        $tax = $subtotal * 0.10;
        $shipping = $subtotal > 100 ? 0 : 10;
        $total = $subtotal + $tax + $shipping;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'buyer_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            // Create order items and update inventory
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->product->price,
                ]);

                $item->product->decrementStock($item->quantity);
            }

            // Clear cart
            Cart::where('buyer_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('buyer.orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process order. Please try again.');
        }
    }

    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->with([
                'orderItems.product.images',
                'orderItems.returns' => function($q) {
                    $q->whereIn('status', ['pending', 'approved']);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Eager load review status
        $allProductIds = $orders->flatMap(function($order) {
            return $order->orderItems->pluck('product_id');
        })->unique();
        
        $reviewedProductIds = \App\Models\Review::where('buyer_id', auth()->id())
            ->whereIn('product_id', $allProductIds)
            ->pluck('product_id')
            ->toArray();

        return view('buyer.orders', compact('orders', 'reviewedProductIds'));
    }

    public function show($id)
    {
        // Allow admins viewing as customer to see any order
        // Regular buyers can only see their own orders
        $query = Order::with([
            'orderItems.product.images',
            'orderItems.returns' => function($q) {
                $q->whereIn('status', ['pending', 'approved']);
            }
        ]);
        
        if (auth()->user()->isAdmin() && session('view_as_customer', false)) {
            // Admin in customer view can see any order
            $order = $query->findOrFail($id);
        } else {
            // Regular buyers can only see their own orders
            $order = $query->where('buyer_id', auth()->id())->findOrFail($id);
        }
        
        // Eager load review status for all products in this order
        $productIds = $order->orderItems->pluck('product_id')->unique();
        $reviewedProductIds = \App\Models\Review::where('buyer_id', auth()->id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();

        return view('buyer.order-detail', compact('order', 'reviewedProductIds'));
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancellation_reason' => 'required|string',
            'custom_reason' => 'nullable|string|max:500',
        ]);

        $order = Order::where('buyer_id', auth()->id())->findOrFail($id);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        // Use custom reason if "other" was selected, otherwise use predefined reason
        $reason = $request->cancellation_reason === 'other' 
            ? $request->custom_reason 
            : $request->cancellation_reason;

        DB::beginTransaction();

        try {
            // Restore inventory
            foreach ($order->orderItems as $item) {
                $item->product->incrementStock($item->quantity);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancellation_reason' => $reason,
            ]);

            DB::commit();

            return back()->with('success', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order. Please try again.');
        }
    }
}
