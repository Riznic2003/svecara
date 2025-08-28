<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamps(); // created_at, updated_at
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
