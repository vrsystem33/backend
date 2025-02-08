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
        Schema::table('users', function (Blueprint $table) {
            // Defining relationships
            $table->foreign('permission_id')->references('uuid')->on('user_permissions')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('set null');
            $table->foreign('gallery_id')->references('uuid')->on('user_galleries')->onDelete('set null');
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('set null');
            $table->foreign('employee_id')->references('uuid')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remover as chaves estrangeiras primeiro
            $table->dropForeign(['permission_id']);
            $table->dropForeign(['role_id']);
            $table->dropForeign(['company_id']);
            $table->dropForeign(['gallery_id']);
            $table->dropForeign(['employee_id']);

            // Depois, remover as colunas
            $table->dropColumn(['permission_id', 'role_id', 'company_id', 'gallery_id', 'employee_id']);
        });
    }
};
