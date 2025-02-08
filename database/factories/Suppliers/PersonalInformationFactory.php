<?php

namespace Database\Factories\Suppliers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Suppliers\PersonalInformation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suppliers\PersonalInformation>
 */
class PersonalInformationFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = PersonalInformation::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'nickname' => $this->faker->userName(),
            'identification' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'phone' => substr($this->faker->phoneNumber(), 0, 11),
            'secondary_phone' => substr($this->faker->phoneNumber(), 0, 11),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->boolean(true)
        ];
    }

    /**
     * Define que o tipo do PersonInfo será admin.
     *
     * @return $this
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'corporate_name' => $this->faker->company . ' Ltda.',
            'trade_name' => $this->faker->word . ' ' . $this->faker->companySuffix,
        ]);
    }

    /**
     * Define que o tipo do PersonInfo será super.
     *
     * @return $this
     */
    public function super(): static
    {
        return $this->state(fn (array $attributes) => [
            'corporate_name' => $this->faker->company . ' Ltda.',
            'trade_name' => $this->faker->word . ' ' . $this->faker->companySuffix,
        ]);
    }
}