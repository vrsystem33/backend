<?php

namespace App\Models\Financial;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialAccount extends BaseModel
{
    // Table associated with the model
    protected $table = 'financial_accounts';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona à empresa dona da conta.
        'account_type_id', // Exemplo: "Corrente", "Poupança", "Carteira Digital"
        'account_name',     // Relaciona à empresa dona da conta.
        'account_number', // Relaciona à conta financeira para recebimento.
        'balance',          // Saldo da conta
        'currency',         // Moeda (Ex: "BRL", "USD", etc)
        'amount',         // Valor a ser pago.
        'status',         // Status (ex: pending, paid, overdue).
        'description',         // Descrição da conta (ex: "Pagamento de aluguel").
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    // Relacionamento com categorias
    public function type(): BelongsTo
    {
        return $this->belongsTo(FinancialAccountType::class, 'account_type_id');
    }

    public function accountsPayable(): HasMany
    {
        return $this->hasMany(AccountsPayable::class, 'financial_account_id');
    }

    public function accountsReceivable(): HasMany
    {
        return $this->hasMany(AccountsReceivable::class, 'financial_account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'financial_account_id');
    }

}
