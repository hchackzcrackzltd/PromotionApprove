<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      View::composer(['Promotion.index','Promotion.status','Promotion.detail','Promotion.duplicate','Approve.index'],'App\Composer\Promotion');
      View::composer(['Promotion.detail','Promotion.duplicate','Approve.index'],'App\Composer\Item');
      View::composer(['Setting.Authorize.add','Setting.Authorize.edit','Setting.Authorize.index'],'App\Composer\Sales');
      View::composer(['Setting.Authorize.index'],'App\Composer\Authorizes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
