<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'TestUser', 'password' => 'password'],
        )->forceFill(['role' => 'customer'])->save();

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password'],
        )->forceFill(['role' => 'admin'])->save();
    }
}
