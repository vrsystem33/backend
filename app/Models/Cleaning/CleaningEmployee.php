<?php

namespace App\Models\Cleaning;

use App\Models\BaseModel;
use App\Models\Companies\Company;

class CleaningEmployee extends BaseModel
{
    // Table associated with the model
    protected $table = 'cleaning_employees';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',              // Identificador único
        'company_id',        // Referência à empresa do funcionário
        'personal_info_id',  // Dados pessoais do funcionário
        'role',              // Função do funcionário, ex: 'Supervisor', 'Auxiliar'
        'shift',             // Turno do funcionário, ex: 'Manhã', 'Tarde'
        'hire_date',         // Data de contratação
        'status',            // Status do funcionário (ativo/inativo)
        'hourly_rate',       // Valor da hora trabalhada
        'availability',      // Disponibilidade do funcionário, ex: 'Full-time', 'Part-time'
    ];

    /**
     * CleaningService.php: Define os diferentes tipos de serviços de limpeza (limpeza simples, pós-obra, limpeza de vidros, etc.).
     * CleaningSchedule.php: Gerencia o agendamento dos serviços de limpeza, com data, hora e local.
     * CleaningEmployee.php: Atribui funcionários para os serviços de limpeza agendados. Isso pode incluir um relacionamento com a tabela Employee.
     */
    // Casting attributes to specific data types
    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'hire_date' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function personalInfo()
    {
        return $this->belongsTo(CleaningEmployeeInformation::class, 'personal_info_id', 'uuid');
    }
}
