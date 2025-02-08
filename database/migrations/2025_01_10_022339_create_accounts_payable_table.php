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
        Schema::create('accounts_payable', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();
            $table->uuid('financial_account_id')->nullable();
            $table->uuid('supplier_id')->nullable();
            $table->timestamp('payment_date')->nullable(); // data de pagemento
            $table->timestamp('due_date')->nullable(); // data de vencimento
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('financial_account_id')->references('uuid')->on('financial_accounts')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('supplier_id')->references('uuid')->on('suppliers')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_payable');
    }
};
