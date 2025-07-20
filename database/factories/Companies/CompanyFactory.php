<?php

namespace Database\Factories\Companies;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\Companies\Company;
use App\Models\Companies\Gallery;
use App\Models\Companies\Address;
use App\Models\Companies\Category;
use App\Models\Companies\PersonalInformation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Companies\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $personalInfo = PersonalInformation::factory()->create();
        $gallery = Gallery::factory()->create();
        $category = Category::factory()->create();
        $address = Address::factory()->create();

        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address_id' => $address->uuid,
            'personal_info_id' => $personalInfo->uuid,
            'gallery_id' => $gallery->uuid,
            'category_id' =>  $category->id,
            'settings' => [
                'currency' => 'BRL',
                'timezone' => 'America/Sao_Paulo',
                'language' => 'pt-BR',
                'max_users' => 5,
                'max_products' => 100,
                'max_sales' => 1000,
            ],
            'business_model' => $this->faker->randomNumber(1),
            'status' => 1,
            'state_registration' => $this->faker->stateAbbr(),
        ];
    }
}
