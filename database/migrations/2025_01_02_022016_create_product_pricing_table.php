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
        Schema::create('product_pricing', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('product_id'); // Relacionamento com o produto
            $table->decimal('cost_price', 10, 2); // Preço de custo do produto
            $table->decimal('sale_price', 10, 2); // Preço de venda do produto
            $table->decimal('margin', 5, 2); // Margem de lucro
            $table->timestamps();
            $table->softDeletes();

            // Chave estrangeira
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_pricing');
    }
};
