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
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id')->nullable();
            $table->uuid('sale_id')->nullable();
            $table->string('payment_method');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('sale_id')->references('uuid')->on('sales')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_payments');
    }
};
