<?php

namespace ShibuyaKosuke\LaravelFormExtend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class HtmlBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Facades
 * @codeCoverageIgnore
 */
class HtmlBuilder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'lara-html';
    }
}
