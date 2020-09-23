<?php

/**
 * Package: ShibuyaKosuke\LaravelFormExtend
 */

use ShibuyaKosuke\LaravelFormExtend\Bootstrap3Form;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4Form;
use ShibuyaKosuke\LaravelFormExtend\BulmaForm;

/**
 * Lara-form
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
    | Default Fontawesome
    |--------------------------------------------------------------------------
    */

    'default_icon' => 'fontawesome5',

    /*
    |--------------------------------------------------------------------------
    | Supported CSS Frameworks
    |--------------------------------------------------------------------------
    */
    'frameworks' => [
        'bootstrap4' => Bootstrap4Form::class,
        'bootstrap3' => Bootstrap3Form::class,
        'bulma' => BulmaForm::class,
    ],

    'css' => [
        'bootstrap4' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
        'bootstrap3' => 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css',
        'bulma' => 'https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon library
    |--------------------------------------------------------------------------
    */

    'icon' => [
        'fontawesome5' => 'https://use.fontawesome.com/releases/v5.14.0/css/all.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Defined form class names
    |--------------------------------------------------------------------------
    */
    "class_name" => [

        'bootstrap4' => [
            // horizontal form
            'left_column_class' => 'col-sm-2 col-md-3 col-form-label',
            'right_column_class' => 'col-sm-10 col-md-9',
            'left_column_offset_class' => 'offset-sm-2 offset-md-3',

            // form elements
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
            // horizontal form
            'left_column_class' => 'control-label text-bold col-sm-2 col-md-3',
            'right_column_class' => 'col-sm-10 col-md-9',
            'left_column_offset_class' => 'col-sm-offset-2 col-md-offset-3',

            // form elements
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
            // horizontal form
            'left_column_class' => 'col-sm-2 col-md-3',
            'right_column_class' => 'col-sm-10 col-md-9',
            'left_column_offset_class' => 'col-sm-offset-2 col-md-offset-3',

            // form elements
            'form_control' => 'input',
            'form_group' => 'field',
            'horizontal' => 'is-horizontal',
            'inline' => null,
            'form_group_error' => null,
            'form_control_error' => 'is-danger',
            'help_text_error' => 'help is-danger',

            'button' => 'button is-primary',

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
