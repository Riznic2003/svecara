<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->paginate(12);
        $cart = session('cart', []); 
        $cartCount = array_sum(array_column($cart, 'qty')) ?: 0;

        return view('shop.index', compact('products','cartCount'));
    }

    
    public function addToCart(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => 'required|integer|min:1|max:100',
        ]);

        $cart = session('cart', []);

        if (!isset($cart[$product->id])) {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float)$product->price,
                'unit'  => $product->unit,
                'qty'   => 0,
            ];
        }

        $cart[$product->id]['qty'] += $data['qty'];

        session(['cart' => $cart]);

        return redirect()->route('shop.cart')->with('ok', 'Proizvod dodat u korpu.');
    }

    
    public function cart()
    {
        $cart = session('cart', []);
        $total = 0.0;
        foreach ($cart as $item) {
            $total += $item['qty'] * $item['price'];
        }
        return view('shop.cart', compact('cart','total'));
    }

    
    public function updateCart(Request $request)
    {
        $items = $request->input('items', []); 
        $cart = session('cart', []);

        foreach ($items as $pid => $qty) {
            $qty = (int)$qty;
            if ($qty <= 0) {
                unset($cart[$pid]);
            } else {
                if (isset($cart[$pid])) {
                    $cart[$pid]['qty'] = min($qty, 100);
                }
            }
        }

        session(['cart' => $cart]);

        return back()->with('ok', 'Korpa ažurirana.');
    }

    
    public function removeFromCart($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('ok', 'Stavka uklonjena.');
    }

    
    public function checkoutForm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('ok', 'Korpa je prazna.');
        }
        $total = 0.0;
        foreach ($cart as $item) $total += $item['qty'] * $item['price'];
        return view('shop.checkout', compact('cart','total'));
    }

    
    public function checkoutStore(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('ok', 'Korpa je prazna.');
        }

        $data = $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:50',
            'address'        => 'required|string|max:500',
            'payment_method' => 'required|string|max:50', 
        ]);

        return DB::transaction(function () use ($cart, $data) {
            
            $total = 0.0;
            foreach ($cart as $it) {
                $total += $it['qty'] * $it['price'];
            }

            
            $order = Order::create([
                'user_id'        => null,
                'full_name'      => $data['full_name'],
                'email'          => $data['email'],
                'phone'          => $data['phone'],
                'address'        => $data['address'],
                'payment_method' => $data['payment_method'],
                'status'         => 'primljena',
                'total'          => $total,
            ]);

            
            foreach ($cart as $it) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $it['id'],
                    'qty'        => $it['qty'],
                    'unit_price' => $it['price'],
                ]);
            }

            
            session()->forget('cart');

            return redirect()->route('shop.thankyou', $order);
        });
    }

    
    public function thankYou(Order $order)
    {
        return view('shop.thankyou', compact('order'));
    }
}
