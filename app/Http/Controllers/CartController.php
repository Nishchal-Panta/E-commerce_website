<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('buyer_id', auth()->id())
            ->with('product.images')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        $tax = $subtotal * 0.10; // 10% tax
        $shipping = $subtotal > 100 ? 0 : 10; // Free shipping over $100
        $total = $subtotal + $tax + $shipping;

        return view('buyer.cart', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->inventory_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart = Cart::where('buyer_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;
            if ($product->inventory_quantity < $newQuantity) {
                return back()->with('error', 'Insufficient stock available.');
            }
            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'buyer_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('buyer_id', auth()->id())->findOrFail($id);

        if ($cart->product->inventory_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function destroy($id)
    {
        $cart = Cart::where('buyer_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
