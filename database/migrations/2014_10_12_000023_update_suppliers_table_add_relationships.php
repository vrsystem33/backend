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
        Schema::table('suppliers', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('personal_info_id')->references('uuid')->on('supplier_personnel_information')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('supplier_categories')->onDelete('set null');
            $table->foreign('address_id')->references('uuid')->on('supplier_addresses')->onDelete('set null');
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['personal_info_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['company_id']);

            // Depois, remover as colunas
            $table->dropColumn(['personal_info_id', 'category_id', 'address_id', 'company_id']);
        });
    }
};
