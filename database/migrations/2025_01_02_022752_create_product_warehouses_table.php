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
        Schema::create('product_warehouses', function (Blueprint $table) {
            $table->uuid('product_id'); // Relacionamento com o produto
            $table->uuid('warehouse_id'); // Relacionamento com o armazém
            $table->integer('stock_quantity'); // Quantidade de produto no armazém
            $table->integer('minimum_stock')->default(0); // Quantidade mínima do produto no armazém
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('uuid')->on('warehouses')->onDelete('cascade');

            // Chave composta
            // $table->primary(['product_id', 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouses');
    }
};
