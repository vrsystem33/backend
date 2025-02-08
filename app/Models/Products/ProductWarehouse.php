<?php

namespace App\Models\Products;

use App\Models\BaseModel;

use App\Models\Warehouse\Warehouse;

class ProductWarehouse extends BaseModel
{
    // Table associated with the model
    protected $table = 'product_warehouses';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'product_id',       // Relaciona com o produto
        'warehouse_id',     // Relaciona com o armazém
        'stock_quantity',   // Quantidade do produto no armazém
        'minimum_stock',    // Quantidade minima do produto permitido no armazém
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com o produto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }

    // Relacionamento com o armazém
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'uuid');
    }
}
