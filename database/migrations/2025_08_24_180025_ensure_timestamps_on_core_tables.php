<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        
        $addTimestampsIfMissing = function (string $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $hasCreated = Schema::hasColumn($tableName, 'created_at');
                $hasUpdated = Schema::hasColumn($tableName, 'updated_at');

                if (!$hasCreated && !$hasUpdated) {
                    
                    $table->timestamps();
                } else {
                    
                    if (!$hasCreated) $table->timestamp('created_at')->nullable();
                    if (!$hasUpdated) $table->timestamp('updated_at')->nullable();
                }
            });
        };

        
        foreach ([
            'categories',
            'products',
            'orders',
            'order_items',
            'stocks',
            'payments', 
            'users',    
        ] as $t) {
            if (Schema::hasTable($t)) {
                $addTimestampsIfMissing($t);
            }
        }
    }

    public function down(): void
    {
        
        foreach ([
            'categories','products','orders','order_items','stocks','payments','users'
        ] as $t) {
            if (Schema::hasTable($t)) {
                Schema::table($t, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'created_at')) {
                        $table->dropColumn('created_at');
                    }
                    if (Schema::hasColumn($table->getTable(), 'updated_at')) {
                        $table->dropColumn('updated_at');
                    }
                });
            }
        }
    }
};
