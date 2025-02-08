<?php

namespace Database\Factories\Companies;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Companies\PersonalInformation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Companies\PersonalInformation>
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
            'nickname' => $this->faker->userName(),
            'corporate_name' => $this->faker->company . ' Ltda.',
            'trade_name' => $this->faker->word . ' ' . $this->faker->companySuffix,
            'identification' => $this->faker->unique()->numberBetween(100000000, 999999999),
            'phone' => substr($this->faker->phoneNumber(), 0, 11),
            'secondary_phone' => substr($this->faker->phoneNumber(), 0, 11),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->boolean(true)
        ];
    }
}