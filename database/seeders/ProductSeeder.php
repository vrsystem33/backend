<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use App\Models\Products\ProductCategory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private string $companyId;

    public function __construct(string $companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedProducts($this->companyId);
    }

    /**
     * Seed products and their associated categories.
     */
    private function seedProducts(string $companyId): void
    {
        $categories = ProductCategory::factory()
            ->state(['company_id' => $companyId])
            ->count(2)
            ->create();

        foreach ($categories as $category) {
            Product::factory()
                ->state([
                    'company_id' => $companyId,
                    'category_id' => $category->uuid
                ])
                ->count(4)
                ->create();
        }
    }
}
