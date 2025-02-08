<?php

namespace Database\Factories\Employees;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Employees\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees\Address>
 */
class AddressFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Address::class;

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
            'postal_code' => $this->faker->postcode(),
            'address' => $this->faker->streetAddress(),
            'number' => $this->faker->buildingNumber(),
            'neighborhood' => $this->faker->word(),
            'complement' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => substr($this->faker->state(), 0, 2),
            'status' => $this->faker->boolean(true)
        ];
    }
}
