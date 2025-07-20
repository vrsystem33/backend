<?php

namespace Database\Factories\Suppliers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\PersonalInformation;
use App\Models\Suppliers\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suppliers\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'company_id' => null,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'personal_info_id' => null,
            'address_id' => null,
            'category_id' => null,
            'status' => $this->faker->boolean(true)
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Supplier $Supplier) {
            if (!$Supplier->personal_info_id) {
                $Supplier->personal_info_id = PersonalInformation::factory()->state(['company_id' => $Supplier->company_id])->create()->uuid;
            }

            if (!$Supplier->address_id) {
                $Supplier->address_id = Address::factory()->state(['company_id' => $Supplier->company_id])->create()->uuid;
            }
        })->afterCreating(function (Supplier $Supplier) {
            if (!$Supplier->personal_info_id) {
                $Supplier->personal_info_id = PersonalInformation::factory()->state(['company_id' => $Supplier->company_id])->create()->uuid;
                $Supplier->save(); // Salva o `personal_info_id` após criar o usuário
            }

            if (!$Supplier->address_id) {
                $Supplier->address_id = Address::factory()->state(['company_id' => $Supplier->company_id])->create()->uuid;
                $Supplier->save(); // Salva o `address_id` após criar o usuário
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
