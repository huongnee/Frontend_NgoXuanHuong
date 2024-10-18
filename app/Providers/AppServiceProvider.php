<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Thêm dòng này
use App\Models\Cart; // Nhớ import model Cart nếu chưa có
use Illuminate\Support\Facades\Auth; // Import Auth để xác thực người dùng
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
        View::composer('*', function ($view) {
            $cart = Cart::with('items')->where('user_id', auth()->id())->first();
            $count = $cart ? $cart->items->sum('quantity') : 0;
            $view->with('count', $count);
        });
    }
}
