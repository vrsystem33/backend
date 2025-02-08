<?php

namespace App\Models;

class Route extends BaseModel
{
    // Table associated with the model
    protected $table = 'routes';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'http_method',
        'url',
        'controller',
        'action',
        'group',
        'scopes',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

}
