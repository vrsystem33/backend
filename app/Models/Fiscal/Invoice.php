<?php

namespace App\Models\Fiscal;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends BaseModel
{
    // Table associated with the model
    protected $table = 'invoices';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'issuer_id',          // ID do emissor da nota fiscal
        'number',             // Número da nota fiscal
        'series',             // Série da nota fiscal
        'issue_date',         // Data de emissão
        'amount',             // Valor total da nota fiscal
        'status',             // Status da nota (emitida, cancelada, etc.)
        'type',               // Tipo da nota fiscal (NF-e ou NFS-e)
        'tax_data',           // Dados fiscais específicos da nota
        'xml_data',           // Dados XML da nota fiscal
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'tax_data' => 'array',
        'xml_data' => 'array',
        'amount' => 'decimal:2',
        'issue_date' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class, 'issuer_id', 'uuid');
    }
}
