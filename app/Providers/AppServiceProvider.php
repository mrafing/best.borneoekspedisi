<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('gw', function(User $user) {
            return $user->outlet->tipe === 'gw';
        });

        Gate::define('mitraa', function(User $user) {
            return $user->outlet->tipe === 'mitra a';
        });

        Gate::define('mitrab', function(User $user) {
            return $user->outlet->tipe === 'mitra b';
        });

        Gate::define('mitrac', function(User $user) {
            return $user->outlet->tipe === 'mitra c';
        });

        Gate::define('gm', function(User $user) {
            return $user->role === 'gm';
        });

        Gate::define('master', function(User $user) {
            return $user->role === 'master';
        });

    }
}
