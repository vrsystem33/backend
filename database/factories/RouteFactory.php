<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'http_method' => 'get',
            'url' => $this->faker->randomElement(['carro/{id}', 'cachorro', 'tenis/{id}', 'computador', 'celular/{id}', 'livro/{id}', 'bicicleta', 'televisao']),
            'controller' => $this->faker->randomElement([
                'Company\CompanyController',
                'User\UserController',
            ]),
            'action' => $this->faker->randomElement([
                'listing',
                'getById',
            ]),
            'group' => $this->faker->randomElement([
                'companies',
                'users',
            ]),
            'scopes' => json_encode($this->faker->randomElements(['super', 'admin', 'employee'], rand(1, 3))),
            'status' => true,
        ];
    }
}
