<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->services();
        $this->repositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    private function services(): void
    {
        $services = [
            'Auth\AuthServiceInterface' => 'Auth\AuthService',
            'Companies\CompanyServiceInterface' => 'Companies\CompanyService',
            'Users\UserServiceInterface' => 'Users\UserService',
            'Products\ProductServiceInterface' => 'Products\ProductService',
        ];

        foreach ($services as $interface => $service) {
            $this->app->bind(
                "App\Services\\$interface",
                "App\Services\\$service"
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    private function repositories(): void
    {
        $repositories = [
            'Auth\AuthRepositoryInterface' => 'Auth\AuthRepository',
            'User\UserRepositoryInterface' => 'User\UserRepository',
            'Role\RoleRepositoryInterface' => 'Role\RoleRepository',
            'Permission\PermissionRepositoryInterface' => 'Permission\PermissionRepository',
            'Admin\AdminRepositoryInterface' => 'Admin\AdminRepository',
            'Companies\CompanyRepositoryInterface' => 'Companies\CompanyRepository',
            'Companies\PersonalInformationRepositoryInterface' => 'Companies\PersonalInformationRepository',
            'Companies\AddressRepositoryInterface' => 'Companies\AddressRepository',
            'Companies\GalleryRepositoryInterface' => 'Companies\GalleryRepository',
            'Route\RouteRepositoryInterface' => 'Route\RouteRepository',
            'Customer\CustomerRepositoryInterface' => 'Customer\CustomerRepository',
            'Customer\CategoryRepositoryInterface' => 'Customer\CategoryRepository',
            'Supplier\SupplierRepositoryInterface' => 'Supplier\SupplierRepository',
            'Supplier\CategoryRepositoryInterface' => 'Supplier\CategoryRepository',
            'Subscription\SubscriptionRepositoryInterface' => 'Subscription\SubscriptionRepository',
            'Products\ProductRepositoryInterface' => 'Products\ProductRepository',
        ];

        foreach ($repositories as $interface => $repository) {
            $this->app->bind(
                "App\Repositories\Contracts\\$interface",
                "App\Repositories\Eloquent\\$repository"
            );
        }
    }
}
