<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BaseModel;

use App\Models\Companies\Company;
use App\Models\Customers\Customer;

class Order extends BaseModel
{
    // Table associated with the model
    protected $table = 'orders';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'customer_id',
        'status',
        'total_price',
        'notes',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(OrderService::class, 'order_id');
    }
}
