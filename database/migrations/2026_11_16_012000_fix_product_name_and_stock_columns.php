<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('products', 'name, 150') && ! Schema::hasColumn('products', 'name')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('name, 150', 'name');
            });
        }

        if (Schema::hasColumn('products', 'stok') && ! Schema::hasColumn('products', 'stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('stok', 'stock');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'name') && ! Schema::hasColumn('products', 'name, 150')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('name', 'name, 150');
            });
        }

        if (Schema::hasColumn('products', 'stock') && ! Schema::hasColumn('products', 'stok')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('stock', 'stok');
            });
        }
    }
};
