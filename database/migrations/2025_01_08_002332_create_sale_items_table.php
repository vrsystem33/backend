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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id')->nullable();
            $table->uuid('sale_id')->nullable();
            $table->uuid('product_id')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('sale_id')->references('uuid')->on('sales')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('product_id')->references('uuid')->on('products')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
