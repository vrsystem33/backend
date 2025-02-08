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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();

            $table->string('plan');

            $table->enum('status', ['active', 'inactive', 'canceled'])->default('active');

            $table->timestamp('start_date')->nullable(); // Data de início da mensalidade
            $table->timestamp('end_date')->nullable(); // Data de expiração da mensalidade
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
        Schema::dropIfExists('subscriptions');
    }
};
