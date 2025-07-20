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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Unique identifier
            $table->uuid('company_id')->nullable(); // FK to companies table
            $table->uuid('order_id')->nullable(); // FK to orders table
            $table->uuid('product_id')->nullable(); // FK to products table
            $table->integer('quantity')->default(1); // Quantity of the product
            $table->decimal('unit_price', 10, 2); // Unit price of the product
            $table->decimal('total_price', 10, 2); // Total price (quantity * unit_price)
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
            $table->foreign('order_id')->references('uuid')->on('orders')->onDelete('set null');
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
