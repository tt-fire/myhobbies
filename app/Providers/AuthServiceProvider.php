<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //hier kann man GATES definieren!
        Gate::define('connect_hobbyTag', function($user, $hobby){
            //nach dem define ist das erste der Name der frei wählbar ist! ->Anwendung des Gates im "hobbyTagController.php"!

            return $user->id === $hobby->user_id || $user->rolle === 'admin'; 
            //antwort ist boolish true oder false
            // nach den beiden || ist die Definition für den Admin!

        });
    }
}
