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
        Schema::create('company_personnel_information', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->string('nickname')->nullable();
            $table->string('corporate_name')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('identification', 20)->nullable();
            $table->string('phone')->nullable();
            $table->string('secondary_phone')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_personnel_information');
    }
};
