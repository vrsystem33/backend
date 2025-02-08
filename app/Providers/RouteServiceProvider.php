<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Carregar rotas dinâmicas
        if (Schema::hasTable('routes')) $this->loadDynamicRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Load dynamic routes from the database.
     */
    protected function loadDynamicRoutes(): void
    {
        $routes = \App\Models\Route::where('status', true)->get();

        // Prefixo para as rotas dinâmicas
        $prefix = 'api/v1/';

        foreach ($routes as $route) {
            // Adicionando o prefixo à URL da rota
            $fullUrl = $prefix . $route->url;

            // Garantir que o controlador tenha o namespace completo
            $controller = 'App\\Http\\Controllers\\' . $route->controller;

            Route::{$route->http_method}($fullUrl, [$controller, $route->action])
                ->middleware(['auth:api', 'check.subscription', 'check.scopes:' . implode(',', json_decode($route->scopes))]);
        }
    }
}
