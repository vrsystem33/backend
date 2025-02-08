<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalePayment extends BaseModel
{
    // Table associated with the model
    protected $table = 'sale_payments';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'sale_id',
        'payment_method', // Exemplo: "Cartão de Crédito", "Boleto", "Pix"
        'amount',
        'status',         // Exemplo: "Pendente", "Aprovado", "Falha"
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
