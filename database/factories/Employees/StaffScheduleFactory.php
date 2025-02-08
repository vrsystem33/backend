<?php

namespace Database\Factories\Employees;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Employees\StaffSchedule;
use App\Models\Companies\Company;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\StaffSchedule>
 */
class StaffScheduleFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = StaffSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(), // Gera um UUID único
            'company_id' => Company::factory(), // Relaciona com a tabela Company
            'employee_id' => null, // Valor inicial que pode ser ajustado
            'name' => $this->faker->randomElement(['Manhã', 'Tarde', 'Noite']), // Nome do turno
            'start_time' => $this->faker->time('H:i:s'), // Horário de início do turno
            'end_time' => $this->faker->time('H:i:s'), // Horário de término do turno
            'status' => $this->faker->boolean(), // Status booleano (ativo ou inativo)
        ];
    }

    public function withCompanyId($companyId): static
    {
        return $this->state(fn (array $attributes) => [
            'company_id' => $companyId,
        ]);
    }
}
