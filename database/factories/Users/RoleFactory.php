<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Users\Role;
use App\Models\Companies\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\Role>
 */
class RoleFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Role::class;

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
            'name' => 'admin',
            'description' => 'Administrador',
            'status' => $this->faker->boolean(true)
        ];
    }
}
