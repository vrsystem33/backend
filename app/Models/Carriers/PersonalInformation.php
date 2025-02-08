<?php

namespace App\Models\Carriers;

use App\Models\BaseModel;
use App\Models\Companies\Company;

class PersonalInformation extends BaseModel
{
    // Table associated with the model
    protected $table = 'carrier_personnel_information';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'name',
        'last_name',
        'identification',
        'phone',
        'secondary_phone',
        'email',
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
        return $this->belongsTo(Company::class, 'uuid', 'company_id');
    }
}
