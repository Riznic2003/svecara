<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', fn () => redirect('/products'));

Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('products',   ProductController::class)->except(['show']);

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\OrderController;


Route::resource('orders', OrderController::class)->only(['index','show']);
Route::post('/orders/{order}/status', [OrderController::class,'updateStatus'])->name('orders.updateStatus');

Route::resource('orders', OrderController::class)->only(['index']);

use App\Http\Controllers\ShopController;

Route::get('/shop',               [ShopController::class, 'index'])->name('shop.index');          
Route::post('/shop/add/{product}',[ShopController::class, 'addToCart'])->name('shop.add');        
Route::get('/cart',               [ShopController::class, 'cart'])->name('shop.cart');            
Route::post('/cart/update',       [ShopController::class, 'updateCart'])->name('shop.cart.update');
Route::post('/cart/remove/{id}',  [ShopController::class, 'removeFromCart'])->name('shop.remove'); 
Route::get('/checkout',           [ShopController::class, 'checkoutForm'])->name('shop.checkout'); 
Route::post('/checkout',          [ShopController::class, 'checkoutStore'])->name('shop.checkout.store'); 
Route::get('/thank-you/{order}',  [ShopController::class, 'thankYou'])->name('shop.thankyou');     


Route::get('/test-checkout', function () {
    return DB::transaction(function () {
        
        $p1 = Product::orderBy('id')->first();
        $p2 = Product::orderBy('id')->skip(1)->first();

        if (!$p1 || !$p2) {
            return 'Nema dovoljno proizvoda (ubaci ProductSeeder pa probaj ponovo).';
        }

        
        $order = Order::create([
            'user_id'        => null,
            'full_name'      => 'Test Kupac',
            'email'          => 'kupac@example.com',
            'phone'          => '060-123-456',
            'address'        => 'Adresa 1, Beograd',
            'payment_method' => 'pouzećem',
            'status'         => 'primljena',
            'total'          => 0,
        ]);

        
        $items = [
            ['product' => $p1, 'qty' => 2],
            ['product' => $p2, 'qty' => 1],
        ];

        $total = 0;
        foreach ($items as $it) {
            $line = OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $it['product']->id,
                'qty'        => $it['qty'],
                'unit_price' => $it['product']->price,
            ]);
            $total += $line->qty * $line->unit_price;
        }

        $order->update(['total' => $total]);

        return "Napravljen order #{$order->id}, total: {$total}";
    });
});
