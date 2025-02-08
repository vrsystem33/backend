<?php

namespace App\Models\Cleaning;

use App\Models\BaseModel;
use App\Models\Companies\Company;

class CleaningService extends BaseModel
{
    // Table associated with the model
    protected $table = 'cleaning_services';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',             // Identificador único
        'company_id',       // Referência à empresa que oferece o serviço
        'category_id',         // Categoria do serviço, ex: 'Residencial', 'Industrial'
        'name',             // Nome do serviço, ex: 'Limpeza Residencial', 'Limpeza Corporativa'
        'description',      // Descrição detalhada do serviço
        'price',            // Preço do serviço
        'duration',         // Duração estimada do serviço (em horas)
        'status',           // Status do serviço (ativo/inativo)
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'price' => 'decimal:2', // Ensures price is always cast to two decimal places
        'duration' => 'float',  // Duration in hours
        'status' => 'boolean',  // Status as boolean
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(CleaningCategory::class, 'category_id', 'uuid');
    }
}
