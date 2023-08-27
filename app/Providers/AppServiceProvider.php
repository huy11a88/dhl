<?php

namespace App\Providers;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('roleShippingStaff', UserRole::fromValue(UserRole::SHIPPING_STAFF));
        View::share('roleCSUser', UserRole::fromValue(UserRole::CUSTOMER_SERVICE_STAFF));
        View::share('roleNormalUser', UserRole::fromValue(UserRole::NORMAL_USER));
        View::share('orderStatusPending', OrderStatus::fromValue(OrderStatus::PENDING));
        View::share('orderStatusProcessing', OrderStatus::fromValue(OrderStatus::PROCESSING));
        View::share('orderStatusShipped', OrderStatus::fromValue(OrderStatus::SHIPPED));
        View::share('orderStatusDelivered', OrderStatus::fromValue(OrderStatus::DELIVERED));
        View::share('orderStatus', OrderStatus::STATUS);
    }
}
