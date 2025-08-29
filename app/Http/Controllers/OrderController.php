<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('items')
            ->orderByDesc('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product.category', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'  => 'required|in:primljena,u_pripremi,isporučena,otkazana',
            'pay'     => 'nullable|boolean',
            'amount'  => 'nullable|numeric|min:0',
            'provider'=> 'nullable|string|max:255',
            'ref'     => 'nullable|string|max:255',
        ]);

        return DB::transaction(function () use ($order, $data) {
            
            $order->update(['status' => $data['status']]);

            
            if ($data['status'] === 'isporučena') {
                $order->load('items.product');
                foreach ($order->items as $it) {
                    
                    $stock = Stock::firstOrCreate(
                        ['product_id' => $it->product_id],
                        ['quantity' => 0, 'location' => 'Magacin 1']
                    );
                    $newQty = max(0, (int)$stock->quantity - (int)$it->qty);
                    $stock->update(['quantity' => $newQty]);
                }
            }

            
            if (isset($data['pay']) && $data['pay']) {
                $amount = $data['amount'] ?? $order->total;

                $payment = Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'amount'    => $amount,
                        'status'    => 'paid',
                        'provider'  => $data['provider'] ?? 'manual',
                        'reference' => $data['ref'] ?? null,
                        'paid_at'   => now(),
                    ]
                );
            }

            return back()->with('ok', 'Porudžbina ažurirana.');
        });
    }
}
