<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    
    public function admin_can_create_product()
    {
        $cat = Category::factory()->create();

        $resp = $this->post('/products', [
            'category_id' => $cat->id,
            'name'        => 'Mirisna sveća',
            'description' => 'Vanila',
            'price'       => 499.99,
            'unit'        => 'kom',
            'sku'         => 'SKU-123',
            'min_stock'   => 2,
        ]);

        $resp->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'name'  => 'Mirisna sveća',
            'sku'   => 'SKU-123',
            'unit'  => 'kom',
            'price' => 499.99,
        ]);
    }

    
    public function product_requires_unique_sku()
    {
        $cat = Category::factory()->create();

        $this->post('/products', [
            'category_id' => $cat->id,
            'name'        => 'A',
            'price'       => 10,
            'unit'        => 'kom',
            'sku'         => 'X1',
        ]);

        $resp = $this->post('/products', [
            'category_id' => $cat->id,
            'name'        => 'B',
            'price'       => 20,
            'unit'        => 'kom',
            'sku'         => 'X1',
        ]);

        $resp->assertSessionHasErrors('sku');
    }
}
