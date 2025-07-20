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
            $table->uuid('plan_id')->nullable();

            $table->string('plan');
            $table->enum('status', ['active', 'inactive', 'canceled'])->default('active');

            $table->timestamp('starts_at'); // Data de início da mensalidade
            $table->timestamp('ends_at')->nullable(); // Data de expiração da mensalidade
            $table->timestamps();
            $table->softDeletes();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('cascade');
            $table->foreign('plan_id')->references('uuid')->on('plans')->onDelete('cascade');
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
