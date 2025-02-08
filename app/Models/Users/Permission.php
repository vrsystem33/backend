<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\Companies\Company;

class Permission extends BaseModel
{
    // Table associated with the model
    protected $table = 'user_permissions';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'module',
        'name',
        'description',
        'create',
        'update',
        'delete',
        'view',
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
