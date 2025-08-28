<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('order_items')) {
            if (Schema::hasColumn('order_items', 'orders_id') && !Schema::hasColumn('order_items', 'order_id')) {
                Schema::table('order_items', function (Blueprint $table) {
                    $table->renameColumn('orders_id', 'order_id');
                });
            }

            if (!Schema::hasColumn('order_items', 'created_at') && !Schema::hasColumn('order_items', 'updated_at')) {
                Schema::table('order_items', function (Blueprint $table) {
                    $table->timestamps();
                });
            }
        }

        if (Schema::hasTable('orders')) {
            if (!Schema::hasColumn('orders', 'created_at') && !Schema::hasColumn('orders', 'updated_at')) {
                Schema::table('orders', function (Blueprint $table) {
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('order_items')) {
            if (Schema::hasColumn('order_items', 'order_id') && !Schema::hasColumn('order_items', 'orders_id')) {
                Schema::table('order_items', function (Blueprint $table) {
                    $table->renameColumn('order_id', 'orders_id');
                });
            }
            if (Schema::hasColumn('order_items', 'created_at')) {
                Schema::table('order_items', function (Blueprint $table) {
                    $table->dropTimestamps();
                });
            }
        }
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'created_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};
