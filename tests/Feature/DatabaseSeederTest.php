<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_an_admin_and_can_run_more_than_once(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->actingAs(User::query()->where('email', 'admin@example.com')->firstOrFail())
            ->get(route('products.create'))
            ->assertOk();
    }
}
