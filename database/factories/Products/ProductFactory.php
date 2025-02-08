<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductPricing;
use App\Models\Products\ProductTax;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Product>
 */
class ProductFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'company_id' => null,
            'category_id' => null,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'barcode' => $this->faker->ean13(),
            'reference' => $this->faker->unique()->bothify('REF-####'),
            'unit' => $this->faker->randomElement(['kg', 'unit']),
            'status' => $this->faker->boolean(true)
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            ProductImage::factory()->state(['product_id' => $product->uuid])->create();
            ProductPricing::factory()->state(['product_id' => $product->uuid])->create();
            ProductTax::factory()->state(['product_id' => $product->uuid])->create();
        });
    }
}
