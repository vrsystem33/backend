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
        Schema::create('payment_terminal_banners', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->uuid('company_id')->nullable();
            $table->uuid('payment_terminal_id')->nullable();
            $table->string('banner_image_url')->nullable();
            $table->decimal('rate_value', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('payment_terminal_id')->references('uuid')->on('payment_terminals')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_terminal_banners');
    }
};
