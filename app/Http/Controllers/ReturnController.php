<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Return as ProductReturn;
use App\Models\ReturnReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Check if an order item can be returned
     */
    private function canReturnOrderItem(OrderItem $orderItem, $userId)
    {
        // Verify ownership
        if ($orderItem->order->buyer_id !== $userId) {
            return ['can_return' => false, 'message' => 'Unauthorized'];
        }

        // Check order status
        if (!in_array($orderItem->order->status, ['delivered', 'completed'])) {
            return ['can_return' => false, 'message' => 'Only delivered orders can be returned.'];
        }

        // Check for existing return
        $existingReturn = $orderItem->returns()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingReturn) {
            return ['can_return' => false, 'message' => 'A return request already exists for this item.'];
        }

        return ['can_return' => true];
    }
    /**
     * Show the form to create a new return request
     */
    public function create($orderItemId)
    {
        $orderItem = OrderItem::with(['order', 'product.images'])->findOrFail($orderItemId);

        $canReturn = $this->canReturnOrderItem($orderItem, auth()->id());
        
        if (!$canReturn['can_return']) {
            if ($canReturn['message'] === 'Unauthorized') {
                abort(403);
            }
            return back()->with('error', $canReturn['message']);
        }

        $returnReasons = ReturnReason::where('is_active', true)->get();

        return view('buyer.returns.create', compact('orderItem', 'returnReasons'));
    }

    /**
     * Store a new return request
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'return_reason_id' => 'nullable|exists:return_reasons,id',
            'custom_reason' => 'nullable|string|max:1000',
        ]);

        if (!$request->return_reason_id && !$request->custom_reason) {
            return back()->withErrors(['reason' => 'Please select a reason or provide a custom reason.']);
        }

        $orderItem = OrderItem::with('order')->findOrFail($request->order_item_id);

        $canReturn = $this->canReturnOrderItem($orderItem, auth()->id());
        
        if (!$canReturn['can_return']) {
            if ($canReturn['message'] === 'Unauthorized') {
                abort(403);
            }
            return back()->with('error', $canReturn['message']);
        }

        DB::beginTransaction();

        try {
            $return = ProductReturn::create([
                'order_id' => $orderItem->order_id,
                'order_item_id' => $request->order_item_id,
                'user_id' => auth()->id(),
                'return_reason_id' => $request->return_reason_id,
                'custom_reason' => $request->custom_reason,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('buyer.returns.show', $return->id)
                ->with('success', 'Return request submitted successfully. Please wait for admin approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit return request. Please try again.');
        }
    }

    /**
     * Show a specific return request
     */
    public function show($returnId)
    {
        $return = ProductReturn::with(['order', 'orderItem.product', 'user', 'returnReason'])
            ->findOrFail($returnId);

        // Verify return belongs to authenticated user
        if ($return->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('buyer.returns.show', compact('return'));
    }

    /**
     * Show all returns for authenticated user
     */
    public function index()
    {
        $returns = ProductReturn::where('user_id', auth()->id())
            ->with(['order', 'orderItem.product', 'returnReason'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('buyer.returns.index', compact('returns'));
    }
}
