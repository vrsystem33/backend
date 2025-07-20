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
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();
            $table->unsignedBigInteger('account_type_id')->nullable();
            $table->string('account_name'); // Nome da conta
            $table->string('account_number')->nullable(); // Número da conta financeira
            $table->decimal('balance', 15, 2)->default(0); // Saldo da conta
            $table->string('currency', 3)->default('BRL'); // Moeda da conta
            $table->decimal('amount', 15, 2)->default(0); // Valor a ser pago
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending'); // Status da conta
            $table->text('description')->nullable(); // Descrição da conta
            $table->timestamps(); // Campos created_at e updated_at
            $table->softDeletes();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('account_type_id')->references('id')->on('financial_account_types')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_accounts');
    }
};
