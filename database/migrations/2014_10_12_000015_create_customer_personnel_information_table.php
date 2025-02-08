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
        Schema::create('customer_personnel_information', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();

            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('identification', 20)->nullable();
            $table->string('phone', 11)->nullable();
            $table->string('secondary_phone', 11)->nullable();
            $table->string('email')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_personnel_information');
    }
};
