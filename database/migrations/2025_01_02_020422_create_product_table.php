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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id'); // Relacionamento com a empresa
            $table->uuid('category_id')->nullable(); // Relacionamento com a categoria (opcional)
            $table->string('name'); // Nome do produto ou serviço
            $table->text('description')->nullable(); // Descrição do produto
            $table->string('barcode')->nullable(); // Código de barras (opcional)
            $table->string('reference')->nullable(); // Referência (opcional)
            $table->string('unit')->nullable(); // Unidade de medida
            $table->enum('type', ['product', 'service'])->default('product'); // Unidade de medida
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Chaves estrangeiras
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('cascade');
            $table->foreign('category_id')->references('uuid')->on('product_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
