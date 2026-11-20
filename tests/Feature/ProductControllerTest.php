<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_index_renders_a_complete_table_when_empty(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('<th>Nama Produk</th>', false)
            ->assertSee('<td colspan="7">Belum ada produk.</td>', false)
            ->assertDontSee('<th>Aksi</th>', false)
            ->assertDontSee(route('products.create', absolute: false), false)
            ->assertSee('name="_token"', false);
    }

    public function test_admin_product_index_renders_management_actions(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $category = Category::create(['name' => 'Phones']);
        $product = Product::create([
            'category_id' => $category->id,
            'product_code' => 'PHONE-1',
            'name' => 'Phone',
            'price' => 100,
            'stock' => 3,
        ]);

        $this->actingAs($admin)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('<th>Aksi</th>', false)
            ->assertSee(route('products.create', absolute: false), false)
            ->assertSee(route('products.edit', $product, absolute: false), false);
    }

    public function test_admin_can_render_the_product_edit_form(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $category = Category::create(['name' => 'Phones']);
        $product = Product::create([
            'category_id' => $category->id,
            'product_code' => 'PHONE-1',
            'name' => 'Phone',
            'price' => 100,
            'stock' => 3,
        ]);

        $this->actingAs($admin)
            ->get(route('products.edit', $product))
            ->assertOk()
            ->assertSee('Edit Produk')
            ->assertSee('name="name"', false);
    }

    public function test_unimplemented_product_and_category_show_routes_reject_get_requests(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $category = Category::create(['name' => 'Phones']);
        $product = Product::create([
            'category_id' => $category->id,
            'product_code' => 'PHONE-1',
            'name' => 'Phone',
            'price' => 100,
            'stock' => 3,
        ]);

        $this->actingAs($admin)
            ->get(route('products.index').'/'.$product->id)
            ->assertMethodNotAllowed();

        $this->actingAs($admin)
            ->get(route('categories.index').'/'.$category->id)
            ->assertMethodNotAllowed();
    }
}
