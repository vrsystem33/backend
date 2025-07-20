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
        Schema::create('employee_staff_schedule', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Primary key
            $table->uuid('company_id')->nullable(); // Foreign key for companies
            $table->uuid('employee_id')->nullable(); // Foreign key for employees
            $table->string('name'); // Shift name, e.g., "Morning", "Afternoon"
            $table->time('start_time'); // Shift start time
            $table->time('end_time'); // Shift end time
            $table->boolean('status')->default(true); // Active/Inactive status
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
            $table->foreign('employee_id')->references('uuid')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_staff_schedule');
    }
};
