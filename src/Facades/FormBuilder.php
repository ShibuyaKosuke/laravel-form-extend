<?php

namespace ShibuyaKosuke\LaravelFormExtend\Facades;

use Illuminate\Support\Facades\Facade;

class FormBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lara-form';
    }
}