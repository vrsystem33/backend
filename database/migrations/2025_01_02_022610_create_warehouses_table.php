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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id'); // Relacionamento com a empresa
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name'); // Nome do armazém
            $table->string('location')->nullable(); // Localização do armazém
            $table->text('description')->nullable(); // Descrição do armazém
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('warehouse_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
