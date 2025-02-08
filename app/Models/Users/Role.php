<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class Role extends BaseModel
{
    //ROLE será geral

    // Table associated with the model
    protected $table = 'user_roles';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
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

    /**
     * Relationship: a role can have multiple users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // "role_id" é a chave estrangeira na tabela "users".
    }
}
