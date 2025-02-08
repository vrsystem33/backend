<?php

namespace App\Models\Warehouse;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Products\Product;

class Warehouse extends BaseModel
{
    // Table associated with the model
    protected $table = 'warehouses';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',          // Identificador único
        'company_id',    // Relaciona com a empresa
        'category_id',    // Relaciona com a empresa
        'name',          // Nome do armazém
        'location',      // Localização do armazém
        'description',   // Localização do armazém
        'status',        // Status do armazém (ativo, inativo)
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

    // Relacionamento com a empresa
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(WarehouseType::class, 'category_id', 'id');
    }

    // Relacionamento com os produtos no armazém
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_warehouses', 'warehouse_id', 'product_id')
            ->withPivot('stock_quantity', 'minimum_stock');  // Relacionamento com a quantidade de cada produto
    }
}
