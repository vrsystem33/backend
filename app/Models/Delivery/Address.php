<?php

namespace App\Models\Delivery;

use App\Models\BaseModel;
use App\Models\Companies\Company;

class Address extends BaseModel
{
    // Table associated with the model
    protected $table = 'delivery_addresses';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'postal_code',
        'address',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company()
    {
        return $this->hasOne(Company::class, 'uuid', 'company_id');
    }
}
