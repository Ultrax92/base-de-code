<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-product', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('view-product', function (User $user, Product $product) {
            return $user->id === $product->user_id || $product->is_public;
        });
    }
}