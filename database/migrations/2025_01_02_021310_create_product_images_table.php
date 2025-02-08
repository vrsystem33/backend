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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('product_id')->nullable(); // Relacionamento com o produto
            $table->string('url')->nullable(); // URL da imagem
            $table->boolean('is_main')->default(false); // Indica se a imagem é a principal
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('product_id')->references('uuid')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
