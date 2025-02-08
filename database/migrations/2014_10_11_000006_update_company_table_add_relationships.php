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
        Schema::table('companies', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('personal_info_id')->references('uuid')->on('company_personnel_information')->onDelete('set null');
            $table->foreign('address_id')->references('uuid')->on('company_addresses')->onDelete('set null');
            $table->foreign('gallery_id')->references('uuid')->on('company_galleries')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('company_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['personal_info_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['gallery_id']);
            $table->dropForeign(['category_id']);

            // Depois, remover as colunas
            $table->dropColumn(['personal_info_id', 'address_id', 'gallery_id', 'category_id']);
        });
    }
};
