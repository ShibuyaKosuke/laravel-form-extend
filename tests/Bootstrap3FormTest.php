<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap3Form;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class FormBuilderTest
 * @package ShibuyaKosuke\LaravelFormExtend\Test
 */
class Bootstrap3FormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var Bootstrap3Form|FormBuilder form */
        $this->form = new Bootstrap3Form($this->app, 'bootstrap3');
    }

    public function testSomeInputHorizontal()
    {
        $this->setType(Bootstrap3Form::HORIZONTAL);

        foreach ($this->types as $type) {
            $name = 'input-name';
            $this->validate($name);
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
        $this->setType(Bootstrap3Form::VERTICAL);

        foreach ($this->types as $type) {
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
        $this->setType(Bootstrap3Form::VERTICAL);
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
        $this->hasClass($output, 'form', 'bootstrap3');
        $this->assertHtml($output, '//form[@class="form-horizontal bootstrap3"]');
    }

    public function testFile()
    {
        $this->setType(Bootstrap3Form::HORIZONTAL);
        $name = 'input-name';
        $label = 'file';
        $type = 'file';
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->horizontal($output);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name']");

        $this->setType(Bootstrap3Form::VERTICAL);
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->hasClass($output, 'div', 'form-group');
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name']");
    }

    public function testSelectHorizontal()
    {
        $this->setType(Bootstrap3Form::HORIZONTAL);
        $name = 'input-name';
        $label = 'select';
        $output = $this->form->select($name, $label);
        $this->select($output, $name);
        $this->horizontal($output);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/select[@name='$name']");
    }

    public function testSelectVertical()
    {
        $this->setType(Bootstrap3Form::VERTICAL);
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
        $classes = explode(' ', implode(' ', [$config['right_column_class']]));
        foreach ($classes as $class) {
            $this->hasClass($output, 'div', $class);
        }
        $classes = explode(' ', implode(' ', [$config['left_column_class']]));
        foreach ($classes as $class) {
            $this->hasClass($output, 'label', $class);
        }
    }

    public function testAddonButton()
    {
        $output = $this->form->addonButton('button')->toHtml();
        $this->hasClass($output, 'div', 'input-group-btn');
        $this->hasClass($output, 'input', 'btn');
        $this->hasClass($output, 'input', 'btn-default');
        $this->assertHtml($output, "//div[@class='input-group-btn']/input");
    }

    public function testAddonText()
    {
        $output = $this->form->addonText('text')->toHtml();
        $this->assertHtml($output, "//div[@class='input-group-addon']/span");
    }

    public function testAddonIcon()
    {
        $output = $this->form->addonIcon('solid.envelope')->toHtml();
        $this->hasClass($output, 'div', 'input-group-addon');
        $this->hasClass($output, 'i', 'fas');
        $this->hasClass($output, 'i', 'fa-envelope');
        $this->assertHtml($output, "//div[@class='input-group-addon']/span/i");
    }

    public function testCheckbox()
    {
        $output = $this->getCheckbox();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div[@class=\"checkbox\"]");
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div[@class=\"checkbox\"]/label"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div[@class=\"checkbox\"]/label/input"
        );
    }

    public function testCheckboxes()
    {
        $output = $this->getCheckboxes();
//        dd($output);
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div/div[@class=\"checkbox\"]", 2);
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/div[@class=\"checkbox\"]/label",
            2
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div/div[@class=\"checkbox\"]/label/input",
            2
        );
    }

    public function testRadio()
    {
        $output = $this->getRadio();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div[@class=\"radio\"]");
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div[@class=\"radio\"]/label"
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div[@class=\"radio\"]/label/input"
        );
    }

    public function testRadios()
    {
        $output = $this->getRadios();
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml($output, "//div[@class=\"form-group\"]/div/div[@class=\"radio\"]", 2);
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/div[@class=\"radio\"]/label",
            2
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]" .
            "/div/div[@class=\"radio\"]/label/input",
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

    public function testFormGroupWithoutLavel()
    {
        $this->setType(Bootstrap3Form::HORIZONTAL);
        $output = $this->form->text('name', false);
        $this->assertHtml($output, '//div[@class="form-group"]/div/input');
    }

    public function testFileOnError()
    {
        $name = 'input-name';
        $label = 'file';
        $type = 'file';
        $this->validate($name);
        $output = $this->form->file($name, $label);
        $this->input($output, $type, $name);
        $this->assertHtml($output, "//div/label[@for=\"$name\"]");
        $this->assertHtml($output, "//div/input[@name=\"$name\"]");
    }

    public function testCheckboxesInline()
    {
        $name = 'checkbox';
        $label = 'checkbox-label';
        $output = $this->form->checkboxes($name, $label, [1 => 'choice-1', 2 => 'choice-2'], [1], true);
        $this->assertHtml($output, "//div[@class=\"form-group\"]");
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/label[@class=\"checkbox-inline\"]",
            2
        );
        $this->assertHtml(
            $output,
            "//div[@class=\"form-group\"]/div/label[@class=\"checkbox-inline\"]/input",
            2
        );
    }
}
