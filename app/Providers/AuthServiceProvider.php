<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       // $this->registerPolicies();
        $this->registerGates();
    }


    protected function registerGates(): void
    {
        try {
            foreach(Permission::pluck('name') as $permission){
                Gate::define($permission, function($user) use($permission) {
                    return $user->hasPermission($permission);
                });
            }
        } catch (\Throwable $th) {
            info('registerPermissions(): Database not found or not yet migrated. Ignoring user permissions while booting app.');
        }
    }
}
