<?php

namespace App\Models\Financial;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends BaseModel
{
    // Table associated with the model
    protected $table = 'transactions';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona à empresa dona da conta.
        'financial_account_id',     // Relaciona à empresa dona da conta.
        'amount', // Relaciona à conta financeira para recebimento.
        'transaction_type', // Exemplo: "Depósito", "Saque", "Transferência"
        'description',          // Saldo da conta
        'transaction_date',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function financialAccount(): BelongsTo
    {
        return $this->belongsTo(FinancialAccount::class, 'financial_account_id');
    }

}
