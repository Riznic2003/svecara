<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    
    public function user_can_checkout_and_order_is_created()
    {
        $product = Product::factory()->create(['price' => 350.00]);

        $this->withSession([
            'cart' => [
                $product->id => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float)$product->price,
                    'unit' => $product->unit,
                    'qty' => 2,
                ],
            ],
        ]);

        $resp = $this->post('/checkout', [
            'full_name'      => 'Test Kupac',
            'email'          => 'kupac@example.com',
            'phone'          => '060123123',
            'address'        => 'Ulica 1, Beograd',
            'payment_method' => 'pouzećem',
        ]);

        $resp->assertRedirect(); 

        $this->assertDatabaseHas('orders', [
            'full_name' => 'Test Kupac',
            'status'    => 'primljena',
            'total'     => 700.00,
        ]);

        $this->assertDatabaseHas('order_items', [
            'qty'        => 2,
            'unit_price' => 350.00,
        ]);
    }

    
    public function checkout_fails_when_cart_is_empty()
    {
        $resp = $this->post('/checkout', [
            'full_name' => 'X', 'email' => 'a@b.c', 'phone' => '1', 'address' => 'x', 'payment_method' => 'pouzećem'
        ]);

        $resp->assertRedirect('/shop'); 
        $this->assertDatabaseCount('orders', 0);
    }
}
