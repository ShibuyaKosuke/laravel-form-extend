<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;
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

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array|string[]
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaraForm' => 'ShibuyaKosuke\LaravelFormExtend\Facades\FormBuilder',
            'LaraHtml' => 'ShibuyaKosuke\LaravelFormExtend\Facades\HtmlBuilder',
        ];
    }

    public function setType($type): void
    {
        /** @var \ReflectionClass $class */
        $class = new \ReflectionClass($this->form);
        $this->method = $class->getMethod('setType');
        $this->method->setAccessible(true);
        $this->method->invoke($this->form, $type);
    }

    protected function assertHtml($output, $expression, $count = 1): void
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

    protected function hasAttribute($output, $tagName, $attribute_name, $value): void
    {
        $dom = new \DOMDocument();
        if ($output instanceof HtmlString) {
            $output = $output->toHtml();
        }
        $dom->loadHTML($output);
        $xpath = new \DOMXPath($dom);

        $elements = $dom->getElementsByTagName($tagName);

        foreach ($elements as $element) {
            /** @var \DOMAttr[] $attributes */
            $attributes = $element->attributes;

            foreach ($attributes as $attribute) {
                if ($attribute->name === $attribute_name && in_array($value, explode(' ', $attribute->value), true)) {
                    $this->assertTrue(true);
                    return;
                }
            }
        }
        $this->assertTrue(false);
    }

    protected function hasClass($output, $tagName, $className): void
    {
        $this->hasAttribute($output, $tagName, 'class', $className);
    }

    abstract public function horizontal($output);

    public function input($output, $type, $name, $value = null): void
    {
        $this->hasAttribute($output, 'input', 'type', $type);
        $this->hasAttribute($output, 'input', 'name', $name);
        if ($value) {
            $this->hasAttribute($output, 'input', 'value', $value);
        }
    }

    public function label($output, $name, $label): void
    {
        $this->hasAttribute($output, 'label', 'for', $name);
    }

    protected function getConfigClass()
    {
        $name = $this->form->name();
        return Arr::get($this->app->config->get(ServiceProvider::KEY), "class_name.$name");
    }

    public function select($output, $name): void
    {
        $this->hasAttribute($output, 'select', 'name', $name);
    }

    public function validate($name): void
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

    protected function getCheckbox(): HtmlString
    {
        $name = 'checkbox';
        $label = 'checkbox-label';
        return $this->form->checkbox($name, $label);
    }

    protected function getCheckboxes(): HtmlString
    {
        $name = 'checkbox';
        $label = 'checkbox-label';
        return $this->form->checkboxes($name, $label, [1 => 'choice-1', 2 => 'choice-2']);
    }

    protected function getRadio(): HtmlString
    {
        $name = 'radio';
        $label = 'radio-label';
        return $this->form->radio($name, $label);
    }

    protected function getRadios(): HtmlString
    {
        $name = 'radio';
        $label = 'radio-label';
        return $this->form->radios($name, $label, [1 => 'choice-1', 2 => 'choice-2']);
    }

    protected function getSelect(): HtmlString
    {
        $name = 'select';
        $label = 'select-label';
        return $this->form->select($name, $label);
    }

    protected function getFile(): HtmlString
    {
        $name = 'file';
        $label = 'file-label';
        return $this->form->file($name, $label);
    }

    protected function getTextarea(): HtmlString
    {
        $name = 'textarea';
        $label = 'textarea-label';
        return $this->form->textarea($name, $label);
    }

    protected function getButton(): HtmlString
    {
        $name = 'button';
        return $this->form->button($name);
    }

    protected function getSubmit(): HtmlString
    {
        $name = 'submit';
        return $this->form->submit($name);
    }
}
