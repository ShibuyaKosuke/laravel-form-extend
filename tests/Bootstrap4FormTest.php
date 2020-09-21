<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4Form;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class FormBuilderTest
 * @package ShibuyaKosuke\LaravelFormExtend\Test
 */
class Bootstrap4FormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var Bootstrap4Form|FormBuilder form */
        $this->form = new Bootstrap4Form($this->app, 'bootstrap4');
    }

    public function testSomeInputHorizontal()
    {
        $this->setType(Bootstrap4Form::HORIZONTAL);

        $types = ['text', 'date', 'number', 'password', 'email', 'tel', 'datetime', 'url', 'search', 'time', 'range'];
        foreach ($types as $type) {
            $name = 'input-name';
            $output = $this->form->input($type, $name);

            $this->horizontal($output);
            $this->label($output, $name, $name);
            $this->input($output, $type, $name);
            $this->hasClass($output, 'input', 'form-control');
            $this->assertHtml($output, '//div/div/input');
        }
    }

    public function testSomeInputVertical()
    {
        $this->setType(Bootstrap4Form::VERTICAL);

        $types = ['text', 'date', 'number', 'password', 'email', 'tel', 'datetime', 'url', 'search', 'time', 'range'];
        foreach ($types as $type) {
            $name = 'input-name';
            $output = $this->form->input($type, $name);

            $this->label($output, $name, $name);
            $this->input($output, $type, $name);
            $this->hasClass($output, 'input', 'form-control');
            $this->assertHtml($output, '//div/label');
            $this->assertHtml($output, '//div/input');
        }
    }

    public function testVerticalInput()
    {
        $this->setType(Bootstrap4Form::VERTICAL);
        $type = 'text';
        $name = 'input-name';
        $output = $this->form->input($type, $name);
        $this->label($output, $name, $name);
        $this->hasClass($output, 'div', 'form-group');
        $this->input($output, $type, $name);
        $this->hasClass($output, 'input', 'form-control');
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name'][@type='$type']");
    }

    public function testHorizontal()
    {
        $output = $this->form->horizontal();
        $this->hasClass($output, 'form', 'form-horizontal');
        $this->hasClass($output, 'form', 'bootstrap4');
        $this->assertHtml($output, '//form[@class="form-horizontal bootstrap4"]');
    }

    public function testFile()
    {
        $this->setType(Bootstrap4Form::HORIZONTAL);
        $name = 'input-name';
        $label = 'file';
        $type = 'file';
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->horizontal($output);
        $this->label($output, $name, $label);
        $this->hasClass($output, 'input', 'form-control-file');
        $this->assertHtml($output, "//div/div/label[@for='$name']");
        $this->assertHtml($output, "//div/div/input[@name='$name']");

        $this->setType(Bootstrap4Form::VERTICAL);
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->hasClass($output, 'div', 'form-group');
        $this->label($output, $name, $label);
        $this->hasClass($output, 'input', 'form-control-file');
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name']");
    }

    public function testSelectHorizontal()
    {
        $this->setType(Bootstrap4Form::HORIZONTAL);
        $name = 'input-name';
        $label = 'select';
        $output = $this->form->select($name, $label);
        $this->select($output, $name);
        $this->horizontal($output);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/div/label[@for='$name']");
        $this->assertHtml($output, "//div/div/select[@name='$name']");
    }

    public function testSelectVertical()
    {
        $this->setType(Bootstrap4Form::VERTICAL);
        $name = 'input-name';
        $label = 'select';
        $output = $this->form->select($name, $label);
        $this->select($output, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/select[@name='$name']");
    }

    public function horizontal($output)
    {
        $config = $this->getConfigClass();
        $classes = explode(' ', implode(' ', [$config['left_column_class'], $config['right_column_class']]));
        foreach ($classes as $class) {
            $this->hasClass($output, 'div', $class);
        }
    }

    public function testAddonButton()
    {
        $output = $this->form->addonButton('button');
        $this->hasClass($output, 'button', 'btn');
        $this->hasClass($output, 'button', 'btn-outline-secondary');
        $this->assertHtml($output, "//div/button");
    }

    public function testAddonText()
    {
        $output = $this->form->addonText('text');
        $this->assertHtml($output, "//div/span");
    }

    public function testAddonIcon()
    {
        $output = $this->form->addonIcon('fas fa-envelope');
        $this->hasClass($output, 'i', 'fas');
        $this->hasClass($output, 'i', 'fa-envelope');
        $this->assertHtml($output, "//div/span/i");
    }
}
