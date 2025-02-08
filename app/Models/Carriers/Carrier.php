<?php

namespace App\Models\Carriers;

use App\Models\BaseModel;

// Relationships with models
use App\Models\Companies\Company;

class Carrier extends BaseModel
{
    // Table associated with the model
    protected $table = 'carriers';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'person_info_id',
        'address_id',
        'category_id',
        'contact_info',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function personalInfo()
    {
        return $this->hasOne(PersonalInformation::class, 'uuid', 'personal_info_id');
    }

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
