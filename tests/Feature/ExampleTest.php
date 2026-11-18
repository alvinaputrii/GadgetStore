<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_inventory_metrics(): void
    {
        $category = Category::create(['name' => 'Phones']);
        Product::create([
            'category_id' => $category->id,
            'product_code' => 'PHONE-1',
            'name' => 'Phone',
            'price' => 100,
            'stock' => 3,
        ]);
        Product::create([
            'category_id' => $category->id,
            'product_code' => 'PHONE-2',
            'name' => 'Phone 2',
            'price' => 200,
            'stock' => 25,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertViewHas('totalStock', 28)
            ->assertViewHas('lowStockProducts', 1)
            ->assertViewHas('inventoryValue', 5300.0)
            ->assertViewHas('stockStatus', [1, 0, 1]);
    }
}
