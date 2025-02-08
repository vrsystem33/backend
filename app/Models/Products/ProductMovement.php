<?php

namespace App\Models\Products;

use App\Models\BaseModel;

class ProductMovement extends BaseModel
{
    // Table associated with the model
    protected $table = 'product_movements'; // Nome da tabela associada a esse modelo

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Atributos que podem ser atribuídos em massa (Mass Assignment)
    protected $fillable = [
        'uuid',          // Identificador único do movimento
        'type',          // Tipo do movimento (ex: entrada, saída)
        'product_id',    // ID do produto relacionado ao movimento
        'user_id',       // ID do usuário que realizou o movimento (geralmente responsável pelo movimento)
        'sale_id',       // ID da venda associada ao movimento (caso seja uma venda)
        'quantity',      // Quantidade de produto movimentada
        'cost_price',    // Preço de custo do produto na transação
        'note_id',       // ID da nota fiscal relacionada
        'note_number',   // Número da nota fiscal
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com a tabela de produtos
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }
}
