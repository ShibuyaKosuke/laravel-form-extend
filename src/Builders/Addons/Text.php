<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
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
     * @param Application $app
     * @param callable $callback
     * @param string $text
     * @param array $options
     */
    public function __construct(Application $app, callable $callback, string $text, array $options = [])
    {
        $this->callback = $callback;
        $this->text = $text;
        $this->options = $options;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toHtml(): string
    {
        $html = call_user_func($this->callback, $this->text, $this->options);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \RuntimeException('Callback not return HtmlString.');
    }
}
