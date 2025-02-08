<?php

namespace Database\Factories\Products;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Products\ProductPricing;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\ProductPricing>
 */
class ProductPricingFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ProductPricing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $costPrice = $this->faker->randomFloat(2, 10, 500); // Gera um preço de custo entre 10 e 500
        $margin = $this->faker->randomFloat(2, 0.1, 0.5); // Gera uma margem de lucro entre 10% e 50%
        $salePrice = $costPrice * (1 + $margin); // Calcula o preço de venda com base na margem

        return [
            'uuid' => Str::uuid(),
            'product_id' => Product::factory(), // Relacionamento com a tabela 'products'
            'cost_price' => $costPrice,
            'sale_price' => $salePrice,
            'margin' => $margin,
        ];
    }
}
