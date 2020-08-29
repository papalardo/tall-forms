<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Forms\Fields\InputField;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InputField::class, function ($app, $params) {
            return InputField::make($params['label'], $params['name'])
                ->type('number');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, config('app.locale'));
        Carbon::setLocale(config('app.locale'));
    }
}
