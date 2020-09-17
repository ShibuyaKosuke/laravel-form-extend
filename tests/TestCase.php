<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap3;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4;
use ShibuyaKosuke\LaravelFormExtend\Bulma;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected $form;
    protected $method;

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set(ServiceProvider::KEY, [

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
                    'left_column_class' => ' control-label text-bold col-sm-2 col-md-3',
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
        ]);
    }

    public function setType($type)
    {
        /** @var \ReflectionClass $class */
        $class = new \ReflectionClass($this->form);
        $this->method = $class->getMethod('setType');
        $this->method->setAccessible(true);
        $this->method->invoke($this->form, $type);
    }

    protected function assertHtml($output, $expression)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($output->toHtml());
        $xpath = new \DOMXPath($dom);
        $ul_nodes = $xpath->evaluate($expression);
        $this->assertEquals(1, $ul_nodes->length);
    }

    protected function getNodeByTagName($output, $tagName)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($output->toHtml());
        return $dom->getElementsByTagName($tagName)->item(0);
    }

    protected function hasAttribute($output, $tagName, $attribute_name, $value)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($output->toHtml());
        $xpath = new \DOMXPath($dom);

        /** @var \DOMNodeList $elements */
        $elements = $dom->getElementsByTagName($tagName);

        foreach ($elements as $element) {
            /** @var \DOMAttr[] $attributes */
            $attributes = $element->attributes;

            foreach ($attributes as $attribute) {
                if ($attribute->name == $attribute_name && in_array($value, explode(' ', $attribute->value))) {
                    $this->assertTrue(true);
                    return;
                }
            }
        }
        $this->assertTrue(false);
    }

    protected function hasClass($output, $tagName, $className)
    {
        $this->hasAttribute($output, $tagName, 'class', $className);
    }

    public function horizontal($output)
    {
        $config = $this->getConfigClass();
        $classes = explode(' ', implode(' ', [$config['left_column_class'], $config['right_column_class']]));
        foreach ($classes as $class) {
            $this->hasClass($output, 'div', $class);
        }
    }

    public function label($output, $name, $label)
    {
        $this->hasAttribute($output, 'label', 'for', $name);
    }

    private function getConfigClass()
    {
        $name = $this->form->name();
        return Arr::get($this->app->config->get(ServiceProvider::KEY), "class_name.$name");
    }
}