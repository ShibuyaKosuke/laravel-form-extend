<?php

namespace ShibuyaKosuke\LaravelFormExtend\Providers;

use ArrayAccess;
use Collective\Html\HtmlBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * Class ServiceProvider
 * @package ShibuyaKosuke\LaravelFormExtend\Providers
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * config key name
     */
    const KEY = 'shibuyakosuke.form_extend';

    /**
     * default config file
     */
    const CONFIG = __DIR__ . '/../../config/form_extend.php';

    /**
     * boot method
     */
    public function boot()
    {
        $this->publishes([
            self::CONFIG => config_path('lara_form.php')
        ], 'lara-form');
    }

    /**
     * register method
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG, self::KEY);

        /**
         * Extends LaravelCollective/HtmlBuilder
         */
        $this->app->singleton('lara-html', function () {
            /** @var Application $app */
            $app = $this->app;
            return new HtmlBuilder($app['url'], $app['view']);
        });

        /**
         * Extends LaravelCollective/FormBuilder
         */
        $this->app->singleton('lara-form', function () {
            /** @var Application $app */
            $app = $this->app;
            $class = $this->defaultClass($app);
            return new $class($app);
        });
    }

    /**
     * get default CSS Framework class name
     *
     * @param Application $app
     * @return array|ArrayAccess|mixed
     * @see /config/form_extend.php
     */
    private function defaultClass(Application $app)
    {
        $config = Arr::get($app['config'], self::KEY);
        $default = Arr::get($config, 'default');
        $frameworks = Arr::get($config, 'frameworks');
        $class = Arr::get($frameworks, $default);
        if (!$app->isProduction()) {
            Log::debug($class);
        }
        return $class;
    }
}