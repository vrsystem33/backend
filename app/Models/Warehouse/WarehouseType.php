<?php

namespace App\Models\Warehouse;

use App\Models\BaseModel;

use App\Models\Companies\Company;

class WarehouseType extends BaseModel
{
    // Table associated with the model
    protected $table = 'warehouse_types';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'warehouse_id ',
        'name',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company()
    {
        return $this->hasOne(Company::class, 'uuid', 'company_id');
    }

    public function warehouse()
    {
        return $this->hasMany(Warehouse::class, 'warehouse_id', 'uuid');
    }
}
