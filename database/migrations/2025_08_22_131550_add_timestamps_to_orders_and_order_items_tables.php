<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    Schema::table('orders', fn (Blueprint $t) => $t->timestamps());
    Schema::table('order_items', fn (Blueprint $t) => $t->timestamps());
}
public function down(): void {
    Schema::table('orders', fn (Blueprint $t) => $t->dropTimestamps());
    Schema::table('order_items', fn (Blueprint $t) => $t->dropTimestamps());
}

};
