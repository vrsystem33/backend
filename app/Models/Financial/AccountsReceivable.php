<?php

namespace App\Models\Financial;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Customers\Customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountsReceivable extends BaseModel
{
    // Table associated with the model
    protected $table = 'accounts_receivable';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona à empresa dona da conta.
        'financial_account_id', // Relaciona à conta financeira para recebimento.
        'customer_id', // Cliente relacionado à conta.
        'receipt_date',
        'due_date',         // Data de vencimento do recebimento.
        'amount',         // Valor a ser pago.
        'status',         // Status (ex: pending, paid, overdue).
        'description',         // Descrição da conta (ex: "Pagamento de aluguel").
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime:d-m-Y H:i:s',
        'due_date' => 'datetime:d-m-Y H:i:s',
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
