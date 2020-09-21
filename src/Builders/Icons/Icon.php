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
     * @var array|\ArrayAccess|mixed
     */
    private $default;

    /**
     * @var string
     */
    private $icon;

    public function __construct(Application $app, string $icon)
    {
        $this->default = Arr::get($app['config']->get(ServiceProvider::KEY), 'default_icon');
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function className()
    {
        return $this->icon;
    }
}
