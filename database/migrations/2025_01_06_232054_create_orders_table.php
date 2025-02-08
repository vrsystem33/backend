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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id')->nullable(); // Relacionamento com a empresa
            $table->uuid('customer_id')->nullable(); // Relacionamento com a empresa
            $table->boolean('status')->default(true);
            $table->decimal('total_price', 10, 2); // Salary with precision and scale
            $table->text('notes'); // Nome do armazém
            $table->timestamps();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
            $table->foreign('customer_id')->references('uuid')->on('customers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
