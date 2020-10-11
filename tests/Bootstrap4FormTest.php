<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4Form;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;
use ShibuyaKosuke\LaravelFormExtend\BulmaForm;

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

        foreach ($this->types as $type) {
            $name = 'input-name';
            $this->validate($name);

            $output = call_user_func_array([$this->form, $type], [$name, $name]);

            $this->horizontal($output);
            $this->label($output, $name, $name);
            $this->input($output, $type, $name);
            $this->hasClass($output, 'input', 'form-control');
            $this->assertHtml($output, '//div/div/input');
        }
    }

    public function testSomeInputHorizontalWithoutLabel()
    {
        $this->setType(Bootstrap4Form::HORIZONTAL);

        foreach ($this->types as $type) {
            $name = 'input-name';
            $output = $this->form->input($type, $name, false);

            $this->input($output, $type, $name);
            $this->hasClass($output, 'input', 'form-control');
            $this->assertHtml($output, '//div/input');
        }
    }

    public function testSomeInputVertical()
    {
        $this->setType(Bootstrap4Form::VERTICAL);

        foreach ($this->types as $type) {
            $name = 'input-name';
            $value = 'value';
            $output = $this->form->input($type, $name, $name, $value);

            $this->label($output, $name, $name);
            $this->input($output, $type, $name, $value);
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

    public function testVerticalInputWithoutLabel()
    {
        $this->setType(Bootstrap4Form::VERTICAL);
        $type = 'text';
        $name = 'input-name';
        $output = $this->form->input($type, $name);
        $this->hasClass($output, 'div', 'form-group');
        $this->input($output, $type, $name);
        $this->hasClass($output, 'input', 'form-control');
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

        $this->validate($name);
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
        $this->validate($name);
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
        $output = $this->form->addonButton('button')->toHtml();
        $this->hasClass($output, 'input', 'btn');
        $this->hasClass($output, 'input', 'btn-outline-secondary');
        $this->assertHtml($output, "//div/input");
    }

    public function testAddonText()
    {
        $output = $this->form->addonText('text')->toHtml();
        $this->assertHtml($output, "//div/span");
    }

    public function testAddonIcon()
    {
        $output = $this->form->addonIcon('solid.envelope')->toHtml();
        $this->hasClass($output, 'i', 'fas');
        $this->hasClass($output, 'i', 'fa-envelope');
        $this->assertHtml($output, "//div/span/i");
    }

    public function testInputWithAddon()
    {
        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['prefix' => $this->form->addonText('addon')]
        );
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->assertHtml($output, "//div/label");

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['suffix' => $this->form->addonButton('addon')]
        );
        $this->assertHtml($output, "//div/label");
    }

    public function testInputHorizontalWithAddon()
    {
        $this->setType(BulmaForm::HORIZONTAL);

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['prefix' => $this->form->addonText('addon')]
        );
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/div/input");

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['suffix' => $this->form->addonIcon('solid.envelope')]
        );
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/div/input");
        $this->assertHtml($output, "//div[@class=\"form-group row\"]/div[@class=\"col-sm-2 col-md-3 col-form-label\"]");
        $this->assertHtml($output, "//div[@class=\"form-group row\"]/div[@class=\"col-sm-10 col-md-9\"]");
        $this->assertHtml($output, "//div[@class=\"input-group\"]/input[@class=\"form-control\"]");

        $this->validate('label');

        $output = $this->form->input(
            'text',
            'label',
            'label',
            null,
            ['prefix' => $this->form->addonIcon('solid.envelope')]
        );
        $this->hasClass($output, 'i', 'fa-envelope');
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group row\"]/div[@class=\"col-sm-2 col-md-3 col-form-label\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group row\"]/div[@class=\"col-sm-10 col-md-9\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"col-sm-10 col-md-9\"]/div[@class=\"input-group is-invalid\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"input-group is-invalid\"]/div[@class=\"input-group-prepend\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"input-group-prepend\"]/span[@class=\"input-group-text\"]"
        );
        $this->assertHtml(
            $output,
            "//span[@class=\"input-group-text\"]/i[@class=\"fas fa-envelope\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"input-group is-invalid\"]/input[@class=\"is-invalid form-control\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"col-sm-10 col-md-9\"]/div[@class=\"invalid-feedback\"]"
        );
    }

    public function testCheckbox()
    {
        $output = $this->getCheckbox();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div[@class=\"form-check\"]");
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]/input[@class=\"form-check-input\"]"
        );
    }

    public function testCheckboxes()
    {
        $output = $this->getCheckboxes();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div/div[@class=\"form-check\"]", 2);
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]",
            2
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]/input[@class=\"form-check-input\"]",
            2
        );
    }

    public function testRadio()
    {
        $output = $this->getRadio();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div[@class=\"form-check\"]");
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]/input[@class=\"form-check-input\"]"
        );
    }

    public function testRadios()
    {
        $output = $this->getRadios();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div/div[@class=\"form-check\"]", 2);
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]",
            2
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div/div[@class=\"form-check\"]/label[@class=\"form-check-label\"]/input[@class=\"form-check-input\"]",
            2
        );
    }

    public function testSelect()
    {
        $output = $this->getSelect();
        $this->assertHtml($output, '//div/label');
        $this->assertHtml($output, '//div/select');
    }

    public function testTextarea()
    {
        $output = $this->getTextarea();
        $this->assertHtml($output, '//div/label');
        $this->assertHtml($output, '//div/textarea');
    }

    public function testButton()
    {
        $output = $this->getButton();
        $this->assertHtml($output, '//div/button');
    }

    public function testSubmit()
    {
        $output = $this->getSubmit();
        $this->assertHtml($output, '//div/input[@class="btn btn-primary"]');
    }

    public function testLabelHtml(): void
    {
        $output = $this->form->text('name', ['html' => 'label' . '<span class="required text-danger">*</span>']);
        $this->assertHtml($output, '//div[@class="form-group"]/label[@for="name"]/span[@class="required text-danger"]');
    }
}
