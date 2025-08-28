<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {


            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete()
                  ->after('id');

            $table->decimal('amount', 10, 2)->after('order_id');
            $table->string('status')->after('amount');          
            $table->string('reference')->nullable()->after('status');
            $table->string('provider')->nullable()->after('reference');
            $table->timestamp('paid_at')->nullable()->after('provider');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {



            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id','amount','status','reference','provider','paid_at']);
        });
    }
};
