<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */


    protected $policies = [
        "App\Model" => "App\Policies\ModelPolicy"
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
        Gate::define("manage-users", function($user) {
            return count(array_intersect(["ADMIN"]));
        });

        Gate::define("manage-categories", function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        Gate::define("manage-books", function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        Gate::define("manage-orders", function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

    }
}
