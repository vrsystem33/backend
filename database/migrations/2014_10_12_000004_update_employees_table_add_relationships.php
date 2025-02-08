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
        Schema::table('employees', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('company_id')->references('uuid')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('personal_info_id')->references('uuid')->on('employee_personnel_information')->onDelete('set null');
            $table->foreign('address_id')->references('uuid')->on('employee_addresses')->onDelete('set null');
            $table->foreign('schedule_id')->references('uuid')->on('employee_staff_schedule')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['company_id']);
            $table->dropForeign(['personal_info_id']);
            $table->dropForeign(['address_id']);
            $table->dropForeign(['schedule_id']);

            // Depois, remover as colunas
            $table->dropColumn([
                'company_id',
                'personal_info_id',
                'address_id',
                'schedule_id'
            ]);
        });
    }
};
