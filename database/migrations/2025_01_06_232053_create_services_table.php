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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->uuid('uuid')->unique(); // Unique identifier
            $table->uuid('company_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name'); // Service name
            $table->text('description')->nullable(); // Detailed description (nullable)
            $table->string('reference')->nullable(); // Referência (opcional)
            $table->decimal('price', 10, 2)->default(0.00); // Service price with default value
            $table->integer('duration')->comment('Duration in minutes'); // Duration in minutes
            $table->boolean('status')->default(true);
            $table->timestamps(); // created_at and updated_at

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('service_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
