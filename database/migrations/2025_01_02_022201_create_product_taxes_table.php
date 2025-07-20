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
        Schema::create('product_taxes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique(); // Chave primária UUID
            $table->uuid('product_id'); // Relacionamento com o produto
            $table->string('ncm'); // NCM (Código de mercadoria)
            $table->string('cfop'); // CFOP (Código fiscal de operação)
            $table->string('cst_icms'); // CST ICMS
            $table->decimal('icms_rate', 5, 2); // Taxa de ICMS
            $table->string('cst_ipi'); // CST IPI
            $table->decimal('ipi_rate', 5, 2); // Taxa de IPI
            $table->string('cst_pis'); // CST PIS
            $table->decimal('pis_rate', 5, 2); // Taxa de PIS
            $table->string('cst_cofins'); // CST COFINS
            $table->decimal('cofins_rate', 5, 2); // Taxa de COFINS
            $table->boolean('withheld_iss')->default(false); // ISS retido
            $table->decimal('iss_rate', 5, 2); // Taxa de ISS
            $table->timestamps();
            $table->softDeletes();

            // Chave estrangeira
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_taxes');
    }
};
