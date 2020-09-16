<?php

namespace ShibuyaKosuke\LaravelFormExtend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FormBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Facades
 */
class FormBuilder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lara-form';
    }
}
