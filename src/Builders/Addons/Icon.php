<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;
use ShibuyaKosuke\LaravelFormExtend\Builders\Icons\Icon as IconType;

/**
 * Class Icon
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Icon
{
    /**
     * @var array|\ArrayAccess|mixed
     */
    private $default;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var IconType
     */
    private $icon;

    /**
     * @var array
     */
    private $options;

    /**
     * Icon constructor.
     * @param Application $app
     * @param callable $callback
     * @param IconType $icon
     * @param array $options
     */
    public function __construct(Application $app, callable $callback, IconType $icon, array $options = [])
    {
        $this->default = Arr::get($app['config']->get(ServiceProvider::KEY), 'default');
        $this->callback = $callback;
        $this->icon = $icon;
        $this->options = $options;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function toHtml()
    {
        $html = call_user_func_array($this->callback, [$this->icon, $this->options]);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \Exception('Callback not return HtmlString.');
    }
}
