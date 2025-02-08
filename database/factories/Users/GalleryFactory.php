<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Users\Gallery;
use App\Models\Companies\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Gallery::class;

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
