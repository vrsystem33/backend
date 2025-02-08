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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id'); // Relacionamento com a empresa
            $table->unsignedBigInteger('parent_id')->nullable(); // Relacionamento com a categoria pai
            $table->string('name'); // Nome da categoria
            $table->text('description')->nullable(); // Descrição da categoria
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
