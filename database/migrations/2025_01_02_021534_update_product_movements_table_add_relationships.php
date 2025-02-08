<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_movements', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('uuid')->on('users')->onDelete('cascade');
            // $table->foreign('sale_id')->references('uuid')->on('sales')->onDelete('set null');
            // $table->foreign('note_id')->references('uuid')->on('notes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_movements', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
            // $table->dropForeign(['sale_id']);
            // $table->dropForeign(['note_id']);

            // Depois, remover as colunas
            $table->dropColumn([
                'product_id',
                'user_id',
                // 'sale_id',
                // 'note_id',
            ]);
        });
    }
};
