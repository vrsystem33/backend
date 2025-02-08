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
        Schema::create('product_movements', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->enum('type', ['entry', 'exit']); // Tipo do movimento (entrada ou saída)
            $table->uuid('product_id'); // Relacionamento com o produto
            $table->uuid('user_id'); // Relacionamento com o usuário que fez o movimento
            $table->uuid('sale_id')->nullable(); // Relacionamento com a venda (opcional)
            $table->integer('quantity'); // Quantidade movimentada
            $table->decimal('cost_price', 10, 2); // Preço de custo do produto
            $table->uuid('note_id')->nullable(); // Relacionamento com a nota fiscal (opcional)
            $table->string('note_number')->nullable(); // Número da nota fiscal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_movements');
    }
};
