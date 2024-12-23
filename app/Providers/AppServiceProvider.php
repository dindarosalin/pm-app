<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\MenuAccessMiddleware;

class AppServiceProvider extends ServiceProvider
{
    protected $user_id;
    protected $menu_id;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app['router']->pushMiddlewareToGroup('web', MenuAccessMiddleware::class);
    }
}
