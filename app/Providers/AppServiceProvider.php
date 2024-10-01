<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;
use DB;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $setting_data = DB::table('settings')->where('id', 10)->first();
        $setting=Setting::first();
        config(['app.timezone'=>$setting_data->timezone]);
        // Make $setting available in all views
    View::composer('*', function ($view) use ($setting) {
        $view->with('setting', $setting);
    });
    }
}
