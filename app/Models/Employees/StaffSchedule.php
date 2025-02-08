<?php

namespace App\Models\Employees;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Relations\HasMany;

// Relationships with models
use App\Models\Companies\Company;

class StaffSchedule extends BaseModel
{
    // Table associated with the model
    protected $table = 'employee_staff_schedule';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'employee_id',
        'name',        // Nome do turno, exemplo: "Manhã", "Tarde", "Noite"
        'start_time',  // Horário de início do turno
        'end_time',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company()
    {
        return $this->hasOne(Company::class, 'uuid', 'gallery_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Employee::class, 'schedule_id');
    }
}
