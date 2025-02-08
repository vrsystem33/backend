<?php

namespace Database\Factories\Customers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Customers\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers\Address>
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
