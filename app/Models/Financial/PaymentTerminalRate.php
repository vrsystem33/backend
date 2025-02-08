<?php

namespace App\Models\Financial;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentTerminalRate extends BaseModel
{
    // Table associated with the model
    protected $table = 'payment_terminal_rates';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona à empresa dona da conta.
        'payment_terminal_id',     // Relaciona à empresa dona da conta.
        'rate_type', // Relaciona à conta financeira para recebimento.
        'rate_value', // Exemplo: "Corrente", "Poupança", "Carteira Digital"
        'description',       // Valor a ser pago.
        'status',   // Descrição da conta (ex: "Pagamento de aluguel").
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'rate_value' => 'decimal:2',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function paymentTerminal(): BelongsTo
    {
        return $this->belongsTo(PaymentTerminal::class, 'payment_terminal_id');
    }

}
