<?php

namespace App\Models\Products;

use App\Models\BaseModel;

class ProductTax extends BaseModel
{
    // Table associated with the model
    protected $table = 'product_taxes';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'product_id',       // ID do produto (chave estrangeira)
        'ncm',              // NCM (código de mercadoria)
        'cfop',             // CFOP (código fiscal de operações e prestações)
        'cst_icms',         // CST ICMS
        'icms_rate',        // Taxa de ICMS
        'cst_ipi',          // CST IPI
        'ipi_rate',         // Taxa de IPI
        'cst_pis',          // CST PIS
        'pis_rate',         // Taxa de PIS
        'cst_cofins',       // CST COFINS
        'cofins_rate',      // Taxa de COFINS
        'withheld_iss',     // ISS retido
        'iss_rate',         // Taxa de ISS
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }
}
