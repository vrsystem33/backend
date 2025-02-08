<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Companies\Company;
use App\Models\Users\User;
use App\Models\Subscription;

use App\Models\Customers\Customer;
use App\Models\Customers\Category;

use App\Models\Employees\Employee;

use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\Category as SupplierCategory;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companySuper = Company::factory()->create();
        $this->seedSuperUsers($companySuper);

        $companies = Company::factory()->count(5)->create();
        foreach ($companies as $company) {
            $this->seedCompanyData($company, $companySuper);
        }
    }

    /**
     * Seed super users for the main company.
     */
    private function seedSuperUsers(Company $companySuper): void
    {
        $employees = Employee::factory()
            ->state([
                'company_id' => $companySuper->uuid,
                'role' => 'desenvolvedor',
                'status' => 1
            ])
            ->count(2)
            ->create();

        foreach ($employees as $employee) {
            User::factory()
                ->state([
                    'company_id' => $companySuper->uuid,
                    'employee_id' => $employee->uuid,
                    'status' => 1
                ])
                ->super($companySuper->uuid)
                ->create();
        }
    }

    /**
     * Seed all necessary data for a company.
     */
    private function seedCompanyData(Company $company, Company $companySuper): void
    {
        Subscription::factory()->state(['company_id' => $company->uuid])->create();

        $this->seedEmployees($company, $companySuper, 'owner', 2, 'admin');
        $this->seedEmployees($company, $companySuper, 'employee', 6, 'employee');
        $this->seedEmployees($company, $companySuper, 'delivery', 2, 'delivery');
        $this->seedCustomers($company);
        $this->seedSuppliers($company);

        $productSeeder = new ProductSeeder($company->uuid);
        $productSeeder->run();
    }

    /**
     * Seed employees and their associated users.
     */
    private function seedEmployees(Company $company, Company $companySuper, string $role, int $count, string $userRole): void
    {
        $employees = Employee::factory()
            ->state(['company_id' => $company->uuid, 'role' => $role, 'status' => 1])
            ->count($count)
            ->create();

        foreach ($employees as $employee) {
            User::factory()
                ->state([
                    'company_id' => $company->uuid,
                    'employee_id' => $employee->uuid,
                    'status' => 1,
                ])
                ->{$userRole}($companySuper->uuid)
                ->create();
        }
    }

    /**
     * Seed customers and their associated categories.
     */
    private function seedCustomers(Company $company): void
    {
        $categories = Category::factory()
            ->state(['company_id' => $company->uuid])
            ->count(2)
            ->create();

        foreach ($categories as $category) {
            Customer::factory()
                ->state(['company_id' => $company->uuid, 'category_id' => $category->id])
                ->count(4)
                ->create();
        }
    }

    /**
     * Seed suppliers and their associated categories.
     */
    private function seedSuppliers(Company $company): void
    {
        $categories = SupplierCategory::factory()
            ->state(['company_id' => $company->uuid])
            ->count(2)
            ->create();

        foreach ($categories as $category) {
            Supplier::factory()
                ->state(['company_id' => $company->uuid, 'category_id' => $category->id])
                ->count(4)
                ->create();
        }
    }
}
