<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class FormBuilderTest
 * @package ShibuyaKosuke\LaravelFormExtend\Test
 */
class FormBuilderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var Bootstrap4|FormBuilder form */
        $this->form = new Bootstrap4($this->app, 'bootstrap4');
    }

    public function testSomeInputHorizontal()
    {
        $this->setType(Bootstrap4::HORIZONTAL);

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
        $this->setType(Bootstrap4::VERTICAL);

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
        $this->setType(Bootstrap4::VERTICAL);
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
        $this->setType(Bootstrap4::HORIZONTAL);
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

        $this->setType(Bootstrap4::VERTICAL);
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
        $this->setType(Bootstrap4::HORIZONTAL);
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
        $this->setType(Bootstrap4::VERTICAL);
        $name = 'input-name';
        $label = 'select';
        $output = $this->form->select($name, $label);
        $this->select($output, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/select[@name='$name']");
    }
}
