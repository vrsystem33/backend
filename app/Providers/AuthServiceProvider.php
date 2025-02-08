<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessClient;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Defina os modelos personalizados para Passport
        Passport::useTokenModel(Token::class);
        Passport::useRefreshTokenModel(RefreshToken::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::useClientModel(Client::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

        // Defina a expiração dos tokens
        Passport::tokensExpireIn(now()->addHours(1));  // Token expira em 1 hora
        Passport::refreshTokensExpireIn(now()->addDays(30));  // Refresh token expira em 30 dias
        Passport::personalAccessTokensExpireIn(now()->addMonths(1));  // Personal Access Tokens expira em 1 mês

        $scopesAllowed = null;
        $defaultRole = new \stdClass();

        if (Schema::hasTable('roles')) {
            // Defina as permissões de tokens
            $scopesAllowed = \App\Models\Users\Role::all()->pluck('description', 'name')->toArray();

            // Defina o escopo padrão dinamicamente
            $defaultRole = \App\Models\Users\Role::query()->first();
        } else {
            $scopesAllowed = [
                'super' => 'Full access',
                'admin' => 'Administrative access',
                'employee' => 'Employee access',
                'delivery' => 'Delivery access',
            ];

            $defaultRole->name = 'super';
        }

        Passport::tokensCan($scopesAllowed);

        // Defina o escopo padrão
        Passport::setDefaultScope([
            'admin',
        ]);
    }
}