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

    'default' => 'bulma',

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

            'button' => 'btn btn-primary',

            'checkbox_wrapper' => 'form-check',
            'checkbox_input' => 'form-check-input',
            'checkbox_label' => 'form-check-label',
            'inline_checkbox_wrapper' => 'form-check form-check-inline',
            'inline_checkbox_input' => 'form-check-input',
            'inline_checkbox_label' => 'form-check-label',

            'radio_wrapper' => 'form-check',
            'radio_input' => 'form-check-input',
            'radio_label' => 'form-check-label',
            'inline_radio_wrapper' => 'form-check form-check-inline',
            'inline_radio_input' => 'form-check-input',
            'inline_radio_label' => 'form-check-label'
        ],

        'bootstrap3' => [
            'form_control' => 'form-control',
            'form_group' => 'form-group',
            'horizontal' => 'form-horizontal',
            'inline' => 'form-inline',
            'form_group_error' => 'has-error',
            'form_control_error' => null,
            'help_text_error' => 'help-block',

            'button' => 'btn btn-primary',

            'checkbox_wrapper' => 'checkbox',
            'checkbox_input' => null,
            'checkbox_label' => null,
            'inline_checkbox_wrapper' => '',
            'inline_checkbox_input' => null,
            'inline_checkbox_label' => 'checkbox-inline',

            'radio_wrapper' => 'radio',
            'radio_input' => null,
            'radio_label' => null,
            'inline_radio_wrapper' => '',
            'inline_radio_input' => null,
            'inline_radio_label' => 'radio-inline'
        ],

        'bulma' => [
            'form_control' => 'input',
            'form_group' => 'field',
            'horizontal' => 'is-horizontal',
            'inline' => null,
            'form_group_error' => null,
            'form_control_error' => 'is-danger',
            'help_text_error' => 'help is-danger',

            'button' => 'button is-link',

            'checkbox_wrapper' => 'control',
            'checkbox_input' => null,
            'checkbox_label' => 'checkbox',
            'inline_checkbox_wrapper' => 'control',
            'inline_checkbox_input' => null,
            'inline_checkbox_label' => 'checkbox',

            'radio_wrapper' => 'control',
            'radio_input' => null,
            'radio_label' => 'radio',
            'inline_radio_wrapper' => 'control',
            'inline_radio_input' => null,
            'inline_radio_label' => 'radio'
        ]
    ]
];
