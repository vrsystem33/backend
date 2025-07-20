<?php

namespace App\Models\Companies;

use App\Models\BaseModel;
use App\Models\Subscription;
use App\Models\Users\User;

class Company extends BaseModel
{
    // Table associated with the model
    protected $table = 'companies';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'personal_info_id',
        'address_id',
        'gallery_id',
        'category_id',
        'subscription_id',
        'business_model',
        'settings',
        'status',
        'state_registration'
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'settings'   => 'array',
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

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'uuid', 'gallery_id');
    }

    public function subscriptions()
    {
        return $this->hasOne(Subscription::class, 'uuid', 'company_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'uuid'); // "company_id" é a chave estrangeira na tabela "users".
    }
}
