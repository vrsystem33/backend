<?php

namespace App\Models\Products;

use App\Models\BaseModel;

class ProductCategory extends BaseModel
{
    // Table associated with the model
    protected $table = 'product_categories';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'id',
        'company_id',
        'parent_id',
        'name',
        'description',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'uuid');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'uuid');
    }
}
