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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->uuid('personal_info_id')->nullable();
            $table->uuid('address_id')->nullable();
            $table->uuid('gallery_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->integer('business_model')->default(1);
            $table->boolean('status')->default(true);

            $table->string('state_registration', 25)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
