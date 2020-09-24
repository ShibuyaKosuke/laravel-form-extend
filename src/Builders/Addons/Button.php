<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

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
     * @param callable $callback
     * @param string $label
     * @param array $options
     */
    public function __construct(callable $callback, string $label, array $options = [])
    {
        $this->callback = $callback;
        $this->label = $label;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function toHtml(): string
    {
        /** @var HtmlString $html */
        $html = call_user_func($this->callback, $this->label, $this->options);
        return $html->toHtml();
    }
}
