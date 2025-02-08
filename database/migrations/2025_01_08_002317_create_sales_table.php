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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id')->nullable(); // Relacionamento com a empresa
            $table->uuid('customer_id')->nullable(); // Relacionamento com a empresa
            $table->uuid('user_id')->nullable(); // Relacionamento com a empresa
            $table->unsignedBigInteger('category_id')->nullable(); // Relacionamento com a empresa
            $table->decimal('total_amount', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('customer_id')->references('uuid')->on('customers')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_id')->references('uuid')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('sale_categories')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
