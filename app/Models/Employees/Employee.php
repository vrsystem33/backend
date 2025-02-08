<?php

namespace App\Models\Employees;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends BaseModel
{
    // Table associated with the model
    protected $table = 'employees';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'personal_info_id',
        'address_id',
        'schedule_id',
        'hire_date',
        'role',
        'salary',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'salary'     => 'decimal:2',
        'hire_date' => 'datetime:d-m-Y H:i:s',
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
        return $this->belongsTo(Company::class, 'uuid', 'gallery_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(StaffSchedule::class, 'employee_id', 'uuid');
    }
}
