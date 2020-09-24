<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Icons;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

/**
 * Class Icon
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Icons
 */
class Icon
{
    /**
     * @var array
     */
    private $icon_fonts;

    /**
     * @var string
     */
    private $icon;

    /**
     * Icon constructor.
     * @param Application $app
     * @param string $icon
     */
    public function __construct(Application $app, string $icon)
    {
        $default = Arr::get($app['config']->get(ServiceProvider::KEY), 'default_icon');
        $this->icon_fonts = $app['config']->get("shibuyakosuke.{$default}");
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function className(): string
    {
        return Arr::get($this->icon_fonts, $this->icon, $this->icon);
    }
}
