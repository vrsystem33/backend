<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Products\Product;

class OrderItem  extends BaseModel
{
    // Table associated with the model
    protected $table = 'order_items';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
