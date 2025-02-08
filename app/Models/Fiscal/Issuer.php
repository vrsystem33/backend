<?php

namespace App\Models\fiscal;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Issuer extends BaseModel
{
    // Table associated with the model
    protected $table = 'issuers';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'tax_id',             // CPF ou CNPJ do emissor
        'personInfo_id',    // Identificador único do emissor
        'address_id',    // Identificador único do emissor
        'is_company',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'is_company' => 'boolean',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'issuer_id', 'uuid');
    }

    public function personInfo(): HasOne
    {
        return $this->hasOne(IssuerInformation::class, 'uuid', 'personInfo_id');
    }

    public function address(): HasOne
    {
        return $this->hasOne(IssuerAddress::class, 'uuid', 'address_id');
    }

}
