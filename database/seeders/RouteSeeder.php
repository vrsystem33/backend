<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating random routes
        Route::factory()->count(4)->create();

        // Create default routes using the helper function
        $this->createRoute('get', 'routes', 'Route\RouteController', 'listing');
        $this->createRoute('get', 'routes/{id}', 'Route\RouteController', 'getById');
        $this->createRoute('post', 'routes', 'Route\RouteController', 'create');
        $this->createRoute('put', 'routes/{id}', 'Route\RouteController', 'update');
        $this->createRoute('delete', 'routes/{id}', 'Route\RouteController', 'delete');
    }

    /**
     * Função para criar uma rota no banco de dados.
     *
     * @param string $method
     * @param string $url
     * @param string $controller
     * @param string $action
     * @return void
     */
    protected function createRoute(string $method, string $url, string $controller, string $action): void
    {
        Route::factory()->create([
            'uuid' => Str::uuid(),
            'http_method' => $method,
            'url' => $url,
            'controller' => $controller,
            'action' => $action,
            'group' => 'routes',
            'scopes' => json_encode(['super'], rand(1, 3)),
            'status' => true,
        ]);
    }
}
