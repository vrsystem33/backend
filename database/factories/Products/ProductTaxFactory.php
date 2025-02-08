<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Products\ProductTax;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\ProductTax>
 */
class ProductTaxFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ProductTax::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'product_id' => null,
            'ncm' => $this->faker->numerify('####.##.##'), // Exemplo: "1234.56.78"
            'cfop' => $this->faker->numerify('####'), // Exemplo: "5102"
            'cst_icms' => $this->faker->randomElement(['00', '10', '20', '30', '40']), // Exemplo de CST ICMS
            'icms_rate' => $this->faker->randomFloat(2, 0, 25), // Taxa de ICMS entre 0% e 25%
            'cst_ipi' => $this->faker->randomElement(['00', '49', '50', '99']), // Exemplo de CST IPI
            'ipi_rate' => $this->faker->randomFloat(2, 0, 15), // Taxa de IPI entre 0% e 15%
            'cst_pis' => $this->faker->randomElement(['01', '02', '03']), // Exemplo de CST PIS
            'pis_rate' => $this->faker->randomFloat(2, 0, 5), // Taxa de PIS entre 0% e 5%
            'cst_cofins' => $this->faker->randomElement(['01', '02', '03']), // Exemplo de CST COFINS
            'cofins_rate' => $this->faker->randomFloat(2, 0, 5), // Taxa de COFINS entre 0% e 5%
            'withheld_iss' => $this->faker->boolean(), // Booleano para ISS retido (true/false)
            'iss_rate' => $this->faker->randomFloat(2, 0, 5),
        ];
    }
}
