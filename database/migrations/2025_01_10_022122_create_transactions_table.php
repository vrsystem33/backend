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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();
            $table->uuid('financial_account_id')->nullable();
            $table->string('transaction_type'); // Exemplo: "Depósito", "Saque", etc.
            $table->text('description')->nullable(); // Descrição da transação
            $table->timestamp('transaction_date'); // Data da transação
            $table->timestamps();
            $table->softDeletes();

            // Chaves estrangeiras
            $table->foreign('company_id')->references('uuid')->on('companies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('financial_account_id')->references('uuid')->on('financial_accounts')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
