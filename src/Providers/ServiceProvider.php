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
 * @codeCoverageIgnore
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * config key name
     */
    public const KEY = 'shibuyakosuke.form_extend';

    /**
     * default config file
     */
    public const CONFIG = __DIR__ . '/../../config/form_extend.php';

    /**
     * @var string|null Css framework
     */
    private $default = null;

    /**
     * boot method
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            self::CONFIG => config_path('lara_form.php')
        ], 'lara-form');
    }

    /**
     * register method
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG, self::KEY);
        $this->mergeConfigFrom(__DIR__ . '/../../config/fontawesome5.php', 'shibuyakosuke.fontawesome5');

        // Dynamic change CSS framework.
        $this->setDefault();

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
            return new $class($app, $this->default);
        });
    }

    /**
     * Set default framework.
     * @return void
     */
    private function setDefault()
    {
        $query = request()->query;
        $this->default = $query->has('type') ?
            $query->get('type') :
            $this->app['config']->get(self::KEY . '.default');
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
        $frameworks = Arr::get($config, 'frameworks');
        $class = Arr::get($frameworks, $this->default);
        if (!$app->isProduction()) {
            Log::debug($class);
        }
        return $class;
    }
}
