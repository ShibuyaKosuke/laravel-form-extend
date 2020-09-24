<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\Icons\Icon as IconType;

/**
 * Class Icon
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Icon
{
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
        $this->callback = $callback;
        $this->icon = $icon;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function toHtml(): string
    {
        $html = call_user_func($this->callback, $this->icon, $this->options);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \RuntimeException('Callback not return HtmlString.');
    }
}
