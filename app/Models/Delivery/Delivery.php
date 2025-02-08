<?php

namespace App\Models\Delivery;

use App\Models\BaseModel;

// Relationships with models
use App\Models\Companies\Company;

class Delivery extends BaseModel
{
    // Table associated with the model
    protected $table = 'deliveries';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'address_id',
        'category_id',
        'order_id',
        'employee_id',
        'carrier_id',
        'delivery_date',
        'delivery_status',
        'delivery_method',
        'tracking_number',
        'notes',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'delivery_date' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function address()
    {
        return $this->hasOne(Address::class, 'uuid', 'address_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'uuid', 'gallery_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
