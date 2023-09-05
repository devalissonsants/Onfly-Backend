<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Outlay;
use App\Policies\OutlayPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Outlay::class => OutlayPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
