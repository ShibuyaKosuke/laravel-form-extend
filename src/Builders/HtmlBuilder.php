<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;

/**
 * Class HtmlBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Builders
 */
class HtmlBuilder
{
    /**
     * @var \Collective\Html\HtmlBuilder
     */
    protected $html;

    public function __construct(UrlGenerator $url, Factory $view)
    {
        if (is_null($this->html)) {
            $this->html = new HtmlBuilder($url, $view);
        }
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->html, $name], $arguments);
    }
}