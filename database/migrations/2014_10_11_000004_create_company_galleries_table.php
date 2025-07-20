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
        Schema::create('company_galleries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->text('photo_full')->nullable();
            $table->text('photo_min')->nullable();
            $table->text('file')->nullable();
            $table->string('name');
            $table->string('extension');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_galleries');
    }
};
