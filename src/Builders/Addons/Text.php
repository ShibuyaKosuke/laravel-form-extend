<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Support\HtmlString;

/**
 * Class Text
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Text
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $options;

    /**
     * Text constructor.
     * @param callable $callback
     * @param string $text
     * @param array $options
     */
    public function __construct(callable $callback, string $text, array $options = [])
    {
        $this->callback = $callback;
        $this->text = $text;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function toHtml(): string
    {
        /** @var HtmlString $html */
        $html = call_user_func($this->callback, $this->text, $this->options);
        return $html->toHtml();
    }
}
