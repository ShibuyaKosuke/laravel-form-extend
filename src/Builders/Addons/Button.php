<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
use Illuminate\Support\HtmlString;

/**
 * Class Button
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Button
{
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
        $this->callback = $callback;
        $this->label = $label;
        $this->options = $options;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toHtml(): string
    {
        $html = call_user_func($this->callback, $this->label, $this->options);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \RuntimeException('Callback not return HtmlString.');
    }
}
