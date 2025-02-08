<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Products\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends BaseModel
{
    // Table associated with the model
    protected $table = 'sale_items';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',     // Relaciona com a empresa
        'sale_id',    // Relaciona com a cliente
        'product_id',        // Relaciona com a usuario que fez a venda
        'quantity',
        'unit_price',
        'discount',
        'total_price',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
