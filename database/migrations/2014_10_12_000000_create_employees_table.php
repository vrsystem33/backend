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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('company_id')->nullable(); // Foreign key for companies
            $table->uuid('personal_info_id')->nullable(); // Nullable foreign key
            $table->uuid('address_id')->nullable(); // Nullable foreign key
            $table->uuid('schedule_id')->nullable(); // Nullable foreign key
            $table->date('hire_date'); // Hiring date
            $table->string('role', 100); // Role, e.g., "Manager", "Clerk"
            $table->decimal('salary', 10, 2); // Salary with precision and scale
            $table->boolean('status')->default(true); // Active/Inactive status
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
