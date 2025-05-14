<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAkses;

class RouteServiceProvider extends ServiceProvider
{
    // ...

    public function boot(): void
    {
        // Register middleware
        Route::middleware('user.akses', UserAkses::class);

        // ...

        $this->routes(function () {
            // ...
        });
    }
}
