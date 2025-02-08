<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Customers\Customer;
use App\Models\Users\User;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends BaseModel
{
    // Table associated with the model
    protected $table = 'sales';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'customer_id',    // Relaciona com a cliente
        'user_id',        // Relaciona com a usuario que fez a venda
        'category_id',    // Relaciona com a categoria
        'total_amount',   // Total
        'discount',       // Desconto
        'tax',            // Taxa
        'status',         // Status (aberto, fechado ou cancelado)
        'notes',          // Comentario se tiver
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SalePayment::class, 'sale_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'uuid');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SaleCategory::class, 'category_id', 'uuid');
    }
}
