<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
		 \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
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

        // Modify the logic of automatic policy discovery
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            /*
             Dynamically return the name of the policy corresponding to the model,such as:'App\Model\User' => 'App\Policies\UserPolicy'
             */
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });

        \Horizon::auth(function ($request) {
<<<<<<< HEAD
            // Is it the webmaster
=======
            // Is it the webmaster?
>>>>>>> L03_5.8
            return \Auth::user()->hasRole('Founder');
        });
    }
}
