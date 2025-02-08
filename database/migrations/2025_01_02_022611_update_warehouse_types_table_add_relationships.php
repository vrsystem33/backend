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
        Schema::table('warehouse_types', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('warehouse_id')->references('uuid')->on('warehouses')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_types', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['company_id']);
            $table->dropForeign(['warehouse_id']);

            // Depois, remover as colunas
            $table->dropColumn([
                'company_id',
                'warehouse_id'
            ]);
        });
    }
};
