<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';
    public function boot()
    {
        parent::boot();
        RateLimiter::for(
            'api',
            function (Request $request) {
                return Limit::perMinute(120)->by(
                    $request->user()?->id ?: $request->ip(),
                );
            },
        );
    }
    public function map()
    {
        $this->mapArtisanRoutes();
        $this->mapAuthApiRoutes();
        $this->mapAppApiRoutes();
        $this->mapDashApiRoutes();
        $this->mapWebsiteRoutes();
        $this->mapWebRoutes();
    }
    protected function mapArtisanRoutes()
    {

        Route::prefix('artisan')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(
                base_path(
                    'routes/artisan.php',
                ),
            );
    }
    protected function mapAuthApiRoutes()
    {
        Route::prefix('auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(
                base_path(
                    'routes/auth.php',
                ),
            );
    }
    protected function mapAppApiRoutes()
    {
        Route::prefix('app')
            ->middleware('api')
            ->namespace(
                $this->namespace,
            )
            ->group(
                base_path(
                    'routes/app.php'
                ),
            );
    }
    protected function mapWebsiteRoutes()
    {
        Route::prefix('dash')
            ->middleware('api')
            ->namespace(
                $this->namespace,
            )
            ->group(
                base_path(
                    'routes/dash.php',
                ),
            );
    }
    protected function mapDashApiRoutes()
    {
        Route::prefix('website')
            ->middleware('api')
            ->namespace(
                $this->namespace,
            )
            ->group(
                base_path(
                    'routes/website.php',
                ),
            );
    }
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace(
                $this->namespace,
            )
            ->group(
                base_path(
                    'routes/web.php',
                ),
            );
    }
}
