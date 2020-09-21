<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

/**
 * Class Button
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Button
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
     * @var string
     */
    private $label;

    /**
     * @var array
     */
    private $options;

    /**
     * Button constructor.
     * @param Application $app
     * @param callable $callback
     * @param string $label
     * @param array $options
     */
    public function __construct(Application $app, callable $callback, string $label, array $options = [])
    {
        $this->default = Arr::get($app['config']->get(ServiceProvider::KEY), 'default');
        $this->callback = $callback;
        $this->label = $label;
        $this->options = $options;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toHtml()
    {
        $html = call_user_func_array($this->callback, [$this->label, $this->options]);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \Exception('Callback not return HtmlString.');
    }
}
