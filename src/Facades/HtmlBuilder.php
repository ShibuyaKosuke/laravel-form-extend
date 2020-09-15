<?php

namespace ShibuyaKosuke\LaravelFormExtend\Facades;

use Illuminate\Support\Facades\Facade;

class HtmlBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lara-html';
    }
}