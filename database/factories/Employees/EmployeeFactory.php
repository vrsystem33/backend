<?php

namespace Database\Factories\Employees;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Employees\Employee;
use App\Models\Companies\Company;
use App\Models\Employees\PersonalInformation;
use App\Models\Employees\Address;
use App\Models\Employees\StaffSchedule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'company_id' => Company::factory(),
            'personal_info_id' => null,
            'address_id' => null,
            'schedule_id' => null,
            'hire_date' => $this->faker->date(),
            'role' => $this->faker->randomElement([
                'Cozinheiro',
                'Tester',
                'Gerente',
                'Analista',
                'Desenvolvedor'
            ]),
            'salary' => $this->faker->randomFloat(2, 2000, 10000),
            'status' => $this->faker->boolean(true)
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Employee $employee) {
            if (!$employee->personal_info_id) {
                $employee->personal_info_id = PersonalInformation::factory()->state(['company_id' => $employee->company_id])->create()->uuid;
            }

            if (!$employee->address_id) {
                $employee->address_id = Address::factory()->state(['company_id' => $employee->company_id])->create()->uuid;
            }

            if (!$employee->schedule_id) {
                $employee->schedule_id = StaffSchedule::factory()->state(['company_id' => $employee->company_id])->create()->uuid;
            }
        })->afterCreating(function (Employee $employee) {
            if (!$employee->personal_info_id) {
                $employee->personal_info_id = PersonalInformation::factory()->state(['company_id' => $employee->company_id])->create()->uuid;
                $employee->save(); // Salva o `personal_info_id` após criar o usuário
            }

            if (!$employee->address_id) {
                $employee->address_id = Address::factory()->state(['company_id' => $employee->company_id])->create()->uuid;
                $employee->save(); // Salva o `address_id` após criar o usuário
            }

            if (!$employee->schedule_id) {
                $employee->schedule_id = StaffSchedule::factory()->state(['company_id' => $employee->company_id, 'employee_id' => $employee->uuid])->create()->uuid;
                $employee->save(); // Salva o `address_id` após criar o usuário
            }
        });
    }

    public function withCompanyId($companyId): static
    {
        return $this->state(fn(array $attributes) => [
            'company_id' => $companyId,
        ]);
    }
}
