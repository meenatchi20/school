<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use App\Policies\StudentPolicy;
use App\Models\Student;
use App\Models\User;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
          Student::class => StudentPolicy::class,
         
    ];



    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addMinutes(30));
        Passport::personalAccessTokensExpireIn(now()->addMinutes(30));
        
    // Gate::define('admin',function($user){
    //     return in_array($user->role->role,['Admin', 'SuperAdmin']);
    //     });

    }
}
