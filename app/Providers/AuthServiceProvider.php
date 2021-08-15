<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // access_token 设定核发后15天后过期
        Passport::tokensExpireIn(now()->addDays(15));

        // refresh_token 设定核发后30天后过期
        Passport::refreshTokensExpireIn(now()->addDays(30));

        // 定义 scope
        Passport::tokensCan([
            'create-animals' => '建立动物资讯',
            'user-info' => '使用者资讯',
        ]);
    }
}
