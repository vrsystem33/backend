<?php

namespace App\Models\Products;

use App\Models\BaseModel;

use App\Models\Warehouse\Warehouse;

class Product extends BaseModel
{
    // Table associated with the model
    protected $table = 'products';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',        // Relaciona com a empresa
        'category_id',       // Relaciona com a categoria
        'name',              // Nome do produto
        'description',       // Descrição do produto
        'barcode',           // Código de barras
        'reference',         // Referência interna ou do fornecedor
        'unit',              // Unidade de medida (ex: kg, unidade)
        'status',            // Status do produto (ativo, inativo)
        'type',              // Tipo do produto (Serviço, Produto)
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'uuid');
    }

    // Relacionamento com a tabela de estoque (product_warehouses)
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouses', 'product_id', 'warehouse_id')
                    ->withPivot('stock_quantity', 'minimum_stock'); // Relacionamento com quantidade no estoque
    }

    // Relacionamento com a tabela de preços
    public function pricing()
    {
        return $this->hasOne(ProductPricing::class, 'product_id', 'uuid');
    }

    // Relacionamento com a tabela de impostos
    public function taxes()
    {
        return $this->hasOne(ProductTax::class, 'product_id', 'uuid');
    }

    // Relacionamento com as imagens
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'uuid');
    }

    // Relacionamento com os movimentos
    public function movements()
    {
        return $this->hasMany(ProductMovement::class, 'product_id', 'uuid');
    }

    public function isService(): bool
    {
        return $this->type === 'service';
    }

    public function isProduct(): bool
    {
        return $this->type === 'product';
    }
}
