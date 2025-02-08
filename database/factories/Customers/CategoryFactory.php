<?php

namespace Database\Factories\Customers;

use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Customers\Category;
use App\Models\Companies\Company;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'name' => $this->faker->word(),
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
