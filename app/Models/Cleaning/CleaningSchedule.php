<?php

namespace App\Models\Cleaning;

use App\Models\BaseModel;
use App\Models\Companies\Company;
use App\Models\Warehouse\Warehouse;

class CleaningSchedule extends BaseModel
{
    // Table associated with the model
    protected $table = 'products';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',              // Identificador único
        'company_id',        // Referência à empresa
        'cleaning_employee_id', // Referência ao funcionário responsável
        'date',              // Data do cronograma
        'start_time',        // Horário de início
        'end_time',          // Horário de término
        'location',          // Local de limpeza
        'description',       // Descrição do serviço de limpeza
        'status',            // Status do cronograma (pendente, concluído, cancelado)
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'start_time' => 'datetime:d-m-Y H:i:s',
        'end_time' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function employee()
    {
        return $this->belongsTo(CleaningEmployee::class, 'cleaning_employee_id', 'uuid');
    }
}
