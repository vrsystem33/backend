<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BaseModel;

use App\Models\Services\Service;

class OrderService extends BaseModel
{
    // Table associated with the model
    protected $table = 'order_services';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'order_id',
        'service_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
