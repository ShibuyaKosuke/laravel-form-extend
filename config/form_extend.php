<?php

/**
 * Package: ShibuyaKosuke\LaravelFormExtend
 */

use ShibuyaKosuke\LaravelFormExtend\Bootstrap3;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4;
use ShibuyaKosuke\LaravelFormExtend\Bulma;

/**
 * Laravel form extend
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Default CSS Framework
    |--------------------------------------------------------------------------
    */

    'default' => 'bootstrap4',

    /*
    |--------------------------------------------------------------------------
    | Supported CSS Frameworks
    |--------------------------------------------------------------------------
    */
    'frameworks' => [
        'bootstrap4' => Bootstrap4::class,
        'bootstrap3' => Bootstrap3::class,
        'bulma' => Bulma::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Defined form class names
    |--------------------------------------------------------------------------
    */
    "class_name" => [

        'bootstrap4' => [
            'form_control' => 'form-control',
            'form_group' => 'form-group',
            'horizontal' => 'form-horizontal',
            'inline' => 'form-inline',
            'form_group_error' => null,
            'form_control_error' => 'is-invalid',
            'help_text_error' => 'invalid-feedback',

            'checkbox_wrapper' => 'form-check',
            'checkbox_input' => 'form-check-input',
            'checkbox_label' => 'form-check-label',
            'inline_checkbox_wrapper' => 'form-check form-check-inline',
            'inline_checkbox_input' => 'form-check-input',
            'inline_checkbox_label' => 'form-check-label'
        ],

        'bootstrap3' => [
            'form_control' => 'form-control',
            'form_group' => 'form-group',
            'horizontal' => 'form-horizontal',
            'inline' => 'form-inline',
            'form_group_error' => 'has-error',
            'form_control_error' => null,
            'help_text_error' => 'help-block',

            'checkbox_wrapper' => 'checkbox',
            'checkbox_input' => null,
            'checkbox_label' => null,
            'inline_checkbox_wrapper' => '',
            'inline_checkbox_input' => null,
            'inline_checkbox_label' => null
        ],

        'bulma' => [
            'form_control' => 'input',
            'form_group' => 'field',
            'horizontal' => 'is-horizontal',
            'inline' => null,
            'form_group_error' => null,
            'form_control_error' => 'is-danger',
            'help_text_error' => 'help is-danger',

            'checkbox_wrapper' => 'form-check',
            'checkbox_input' => 'form-check-input',
            'checkbox_label' => 'checkbox',
            'inline_checkbox_wrapper' => 'form-check form-check-inline',
            'inline_checkbox_input' => 'form-check-input',
            'inline_checkbox_label' => 'form-check-label'
        ]
    ]
];
