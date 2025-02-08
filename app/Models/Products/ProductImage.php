<?php

namespace App\Models\Products;

use App\Models\BaseModel;

class ProductImage extends BaseModel
{
    // Table associated with the model
    protected $table = 'product_images';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'product_id',
        'url',
        'is_main',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }
}
