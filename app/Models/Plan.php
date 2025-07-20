<?php

namespace App\Models;

class Plan extends BaseModel
{
    // Table associated with the model
    protected $table = 'plans';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'currency',
        'country',
        'city',
        'region',
        'price',
        'max_users',
        'max_products',
        'max_sales',
        'status', // 'true' || 'false'
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

    protected $dates = [];
}
