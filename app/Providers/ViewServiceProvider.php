<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.*', function($view) {
            $menus = config('menu')['admin_menu'];
            $view->with('menus', $menus);
        });

        $usrMenu = collect(config('menu')['menu'])->pluck('viewName')->toArray();
        View::composer($usrMenu, function($view) {
            $menus = config('menu')['menu'];
            $view->with('menus', $menus);
        });
    }
}
