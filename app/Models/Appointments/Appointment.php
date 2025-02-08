<?php

namespace App\Models\Appointments;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\BaseModel;

use App\Models\Companies\Company;
use App\Models\Customers\Customer;
use App\Models\Employees\Employee;
use App\Models\Services\Service;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends BaseModel
{
    // Table associated with the model
    protected $table = 'appointments';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'customer_id ',
        'service_id',
        'employee_id ',
        'status_id',
        'type_id',
        'scheduled_date',
        'total_price',
        'time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'scheduled_date' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'uuid', 'company_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'uuid', 'customer_id');
    }

    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'uuid', 'service_id');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'uuid', 'employee_id');
    }

    public function address(): HasMany
    {
        return $this->hasMany(AppointmentAddress::class, 'appointment_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(AppointmentItem::class, 'appointment_id');
    }

    public function history(): HasMany
    {
        return $this->hasMany(AppointmentHistory::class, 'appointment_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(AppointmentStatus::class, 'status_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class, 'type_id');
    }
}
