<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;

/**
 * Class HtmlBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Builders
 * @codeCoverageIgnore
 */
class HtmlBuilder
{
    /**
     * @var \Collective\Html\HtmlBuilder
     */
    protected $html;

    /**
     * HtmlBuilder constructor.
     * @param UrlGenerator $url
     * @param Factory $view
     */
    public function __construct(UrlGenerator $url, Factory $view)
    {
        if (is_null($this->html)) {
            $this->html = new HtmlBuilder($url, $view);
        }
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters = [])
    {
        return call_user_func_array([$this->html, $method], $parameters);
    }
}
