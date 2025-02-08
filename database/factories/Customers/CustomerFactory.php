<?php

namespace Database\Factories\Customers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Customers\Customer;
use App\Models\Customers\PersonalInformation;
use App\Models\Customers\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Customer::class;

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
        return $this->afterMaking(function (Customer $customer) {
            if (!$customer->personal_info_id) {
                $customer->personal_info_id = PersonalInformation::factory()->state(['company_id' => $customer->company_id])->create()->uuid;
            }

            if (!$customer->address_id) {
                $customer->address_id = Address::factory()->state(['company_id' => $customer->company_id])->create()->uuid;
            }
        })->afterCreating(function (Customer $customer) {
            if (!$customer->personal_info_id) {
                $customer->personal_info_id = PersonalInformation::factory()->state(['company_id' => $customer->company_id])->create()->uuid;
                $customer->save(); // Salva o `personal_info_id` após criar o usuário
            }

            if (!$customer->address_id) {
                $customer->address_id = Address::factory()->state(['company_id' => $customer->company_id])->create()->uuid;
                $customer->save(); // Salva o `address_id` após criar o usuário
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
