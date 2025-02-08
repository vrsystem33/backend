<?php

namespace Database\Factories\Companies;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Companies\Gallery;
use App\Models\Companies\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Companies\Gallery>
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
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->word(),
            'extension' => $this->faker->randomElement([
                'jpg',
                'jpeg',
                'png',
                'gif'
            ])
        ];
    }
}