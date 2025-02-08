<?php

namespace App\Models\Appointments;

use App\Models\BaseModel;

use App\Models\Companies\Company;
use App\Models\Customers\Customer;

class AppointmentType extends BaseModel
{
    // Table associated with the model
    protected $table = 'appointment_types';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'appointmente_id ',
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

    public function customer()
    {
        return $this->hasOne(Customer::class, 'uuid', 'customer_id');
    }
}
