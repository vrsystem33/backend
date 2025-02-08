<?php

namespace App\Models\Suppliers;

use App\Models\BaseModel;

// Relationships with models
use App\Models\Companies\Company;

class Supplier extends BaseModel
{
    // Table associated with the model
    protected $table = 'suppliers';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'company_id',
        'category_id',
        'address_id',
        'personal_info_id',
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

    public function personalInfo()
    {
        return $this->hasOne(PersonalInformation::class, 'uuid', 'personInfo_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'uuid', 'address_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
