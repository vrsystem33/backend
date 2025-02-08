<?php

namespace App\Models\Financial;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Suppliers\Supplier;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountsPayable extends BaseModel
{
    // Table associated with the model
    protected $table = 'accounts_payable';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'financial_account_id',
        'supplier_id', // Exemplo: "Cartão de Crédito", "Boleto", "Pix"
        'payment_date',
        'due_date',         // Data de vencimento do pagamento.
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

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}
