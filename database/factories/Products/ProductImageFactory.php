<?php

namespace Database\Factories\Products;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Products\ProductImage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'product_id' => Product::factory(),
            'url' => $this->faker->imageUrl(),
            'is_main' => $this->faker->boolean(true),
        ];
    }
}
