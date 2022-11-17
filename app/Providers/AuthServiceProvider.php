<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    
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

        //for menu
        Gate::define('isAdmin', function(user $user){
            return $user->roles_id == 1;
        });
        //
        Gate::define('isUser', function(user $user){
            return $user->roles_id == 2;
        });
    }
}
