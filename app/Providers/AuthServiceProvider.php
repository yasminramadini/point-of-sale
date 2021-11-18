<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchase;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
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

        Gate::define('admin', function(User $user) {
          return $user->role === 1;
        });
        
        Gate::define('cancelSale', function(User $user, Sale $sale) {
          return $user->id === $sale->user_id;
        });
        
        Gate::define('cancelPurchase', function(User $user, $id) {
          return $user->id === $id;
        });
        
    }
}
