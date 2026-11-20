<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_index_shows_status_without_admin_actions_for_customers(): void
    {
        $user = User::factory()->create();
        Category::create(['name' => 'Accessories']);

        $this->actingAs($user)
            ->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Accessories')
            ->assertSee('aktif')
            ->assertDontSee(route('categories.create', absolute: false), false)
            ->assertDontSee('<th>Aksi</th>', false);
    }

    public function test_admin_category_index_renders_management_actions(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        $category = Category::create(['name' => 'Accessories']);

        $this->actingAs($admin)
            ->get(route('categories.index'))
            ->assertOk()
            ->assertSee('<th>Aksi</th>', false)
            ->assertSee(route('categories.create', absolute: false), false)
            ->assertSee(route('categories.edit', $category, absolute: false), false);
    }
}
