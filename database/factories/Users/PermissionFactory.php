<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Companies\Company;
use App\Models\Users\Permission;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'company_id' => Company::factory(),
            'create' => $this->faker->boolean(),
            'update' => $this->faker->boolean(),
            'delete' => $this->faker->boolean(),
            'view' => $this->faker->boolean(),
            'status' => $this->faker->boolean(true)
        ];
    }

    public function withCompanyId($companyId): static
    {
        return $this->state(fn (array $attributes) => [
            'company_id' => $companyId,
        ]);
    }
}
