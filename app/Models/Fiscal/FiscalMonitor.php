<?php

namespace App\Models\Fiscal;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiscalMonitor extends BaseModel
{
    // Table associated with the model
    protected $table = 'fiscal_monitors';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'operation_type',     // Tipo da operação fiscal (ex: venda, compra, devolução)
        'status',             // Status do monitoramento (ex: ativo, inativo, pendente)
        'last_check_at',      // Última data de verificação
        'log',      // Registro das operações monitoradas (pode ser JSON ou texto)
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
