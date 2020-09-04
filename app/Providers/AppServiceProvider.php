<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\FormFields\LivewireFields\Fields\InputField;
use App\FormFields\LivewireFields\Config\ConfigLivewireFields;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InputField::class, function ($app, $params = []) {
            return new InputField($params['label'], $params['name']);
        });

        $this->app->singleton(ConfigLivewireFields::class, function () {
            return new ConfigLivewireFields();
        });

        ConfigLivewireFields::make()
            ->widthSize(12);
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
