<?php

namespace ShibuyaKosuke\LaravelFormExtend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FormBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Facades
 * @codeCoverageIgnore
 */
class FormBuilder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'lara-form';
    }
}
