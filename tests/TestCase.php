<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap3Form;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4Form;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;
use ShibuyaKosuke\LaravelFormExtend\BulmaForm;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @var FormBuilder
     */
    protected $form;
    protected $method;
    protected $types = [
        'text',
        'date',
        'number',
        'password',
        'email',
        'tel',
        'datetime',
        'url',
        'search',
        'time',
        'range',
        'week',
        'color'
    ];

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
                'bootstrap4' => Bootstrap4Form::class,
                'bootstrap3' => Bootstrap3Form::class,
                'bulma' => BulmaForm::class
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

    protected function assertHtml($output, $expression, $count = 1)
    {
        if ($output instanceof HtmlString) {
            $output = $output->toHtml();
        }
        $dom = new \DOMDocument();
        $dom->loadHTML($output);
        $xpath = new \DOMXPath($dom);
        $ul_nodes = $xpath->evaluate($expression);
        $this->assertEquals($count, $ul_nodes->length);
    }

    protected function getNodeByTagName($output, $tagName)
    {
        if ($output instanceof HtmlString) {
            $output = $output->toHtml();
        }
        $dom = new \DOMDocument();
        $dom->loadHTML($output);
        return $dom->getElementsByTagName($tagName)->item(0);
    }

    protected function hasAttribute($output, $tagName, $attribute_name, $value)
    {
        $dom = new \DOMDocument();
        if ($output instanceof HtmlString) {
            $output = $output->toHtml();
        }
        $dom->loadHTML($output);
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

    abstract public function horizontal($output);

    public function input($output, $type, $name)
    {
        $this->hasAttribute($output, 'input', 'type', $type);
        $this->hasAttribute($output, 'input', 'name', $name);
    }

    public function label($output, $name, $label)
    {
        $this->hasAttribute($output, 'label', 'for', $name);
    }

    protected function getConfigClass()
    {
        $name = $this->form->name();
        return Arr::get($this->app->config->get(ServiceProvider::KEY), "class_name.$name");
    }

    public function select($output, $name)
    {
        $this->hasAttribute($output, 'select', 'name', $name);
    }

    public function validate($name)
    {
        $formBuilder = $this->form;

        /** @var \Collective\Html\FormBuilder $form */
        $class = new \ReflectionClass($formBuilder);

        $appProperty = $class->getProperty('app');
        $appProperty->setAccessible(true);
        $app = $appProperty->getValue($formBuilder);

        $formProperty = $class->getProperty('form');
        $formProperty->setAccessible(true);
        $form = $formProperty->getValue($formBuilder);

        $form->setSessionStore($app['session.store']);

        $validator = Validator::make([$name => null], [$name => 'required']);
        $errorBugs = new ViewErrorBag();
        $messageBag = new MessageBag();
        $messageBag->add($name, $validator->errors()->first($name));
        $errorBugs->put('default', $messageBag);

        $store = $form->getSessionStore();
        $store->put('errors', $errorBugs);
    }

    protected function getCheckbox()
    {
        $name = 'checkbox';
        $label = 'checkbox-label';
        return $this->form->checkbox($name, $label);
    }

    protected function getCheckboxes()
    {
        $name = 'checkbox';
        $label = 'checkbox-label';
        return $this->form->checkboxes($name, $label, [1 => 'choice-1', 2 => 'choice-2¬']);
    }

    protected function getRadio()
    {
        $name = 'radio';
        $label = 'radio-label';
        return $this->form->radio($name, $label);
    }

    protected function getRadios()
    {
        $name = 'radio';
        $label = 'radio-label';
        return $this->form->radios($name, $label, [1 => 'choice-1', 2 => 'choice-2¬']);
    }

    protected function getSelect()
    {
        $name = 'select';
        $label = 'select-label';
        return $this->form->select($name, $label);
    }

    protected function getFile()
    {
        $name = 'file';
        $label = 'file-label';
        return $this->form->file($name, $label);
    }

    protected function getTextarea()
    {
        $name = 'textarea';
        $label = 'textarea-label';
        return $this->form->textarea($name, $label);
    }

    protected function getButton()
    {
        $name = 'button';
        return $this->form->button($name);
    }

    protected function getSubmit()
    {
        $name = 'submit';
        return $this->form->submit($name);
    }
}
