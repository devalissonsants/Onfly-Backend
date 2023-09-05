<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(15));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
