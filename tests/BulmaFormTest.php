<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\BulmaForm;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class FormBuilderTest
 * @package ShibuyaKosuke\LaravelFormExtend\Test
 */
class BulmaFormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var BulmaForm|FormBuilder form */
        $this->form = new BulmaForm($this->app, 'bulma');
    }

    public function testSomeInputHorizontal()
    {
        $this->setType(BulmaForm::HORIZONTAL);

        $types = ['text', 'date', 'number', 'password', 'email', 'tel', 'datetime', 'url', 'search', 'time', 'range'];
        foreach ($types as $type) {
            $name = 'input-name';
            $output = $this->form->input($type, $name);

            $this->label($output, $name, $name);
            $this->input($output, $type, $name);
            $this->assertHtml($output, '//div/div/input');
        }
    }

    public function testSomeInputVertical()
    {
        $this->setType(BulmaForm::VERTICAL);

        $types = ['text', 'date', 'number', 'password', 'email', 'tel', 'datetime', 'url', 'search', 'time', 'range'];
        foreach ($types as $type) {
            $name = 'input-name';
            $output = $this->form->input($type, $name);

            $this->label($output, $name, $name);
            $this->input($output, $type, $name);
            $this->assertHtml($output, '//div/label');
            $this->assertHtml($output, '//div/input');
        }
    }

    public function testVerticalInput()
    {
        $this->setType(BulmaForm::VERTICAL);
        $type = 'text';
        $name = 'input-name';
        $output = $this->form->input($type, $name);
        $this->label($output, $name, $name);
        $this->input($output, $type, $name);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name'][@type='$type']");
    }

    public function testHorizontal()
    {
        $output = $this->form->horizontal();
        $this->hasClass($output, 'form', 'is-horizontal');
        $this->hasClass($output, 'form', 'bulma');
        $this->assertHtml($output, '//form[@class="is-horizontal bulma"]');
    }

    public function testFile()
    {
        $this->setType(BulmaForm::HORIZONTAL);
        $name = 'input-name';
        $label = 'file';
        $type = 'file';
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/div/label[@for='$name']");
        $this->assertHtml($output, "//div/div/input[@name='$name']");

        $this->setType(BulmaForm::VERTICAL);
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name']");
    }

    public function testSelectHorizontal()
    {
        $this->setType(BulmaForm::HORIZONTAL);
        $name = 'input-name';
        $label = 'select';
        $output = $this->form->select($name, $label);
        $this->select($output, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/div/label[@for='$name']");
        $this->assertHtml($output, "//div/div/select[@name='$name']");
    }

    public function testSelectVertical()
    {
        $this->setType(BulmaForm::VERTICAL);
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
        $output = $this->form->addonButton('button')->toHtml();
        $this->hasClass($output, 'button', 'button');
        $this->assertHtml($output, "//p/button");
    }

    public function testAddonText()
    {
        $output = $this->form->addonText('text')->toHtml();
        $this->assertHtml($output, "//p/a[@class='button is-static']");
    }

    public function testAddonIcon()
    {
        $output = $this->form->addonIcon('fas fa-envelope')->toHtml();
        $this->hasClass($output, 'span', 'icon');
        $this->hasClass($output, 'span', 'is-small');
        $this->hasClass($output, 'i', 'fas');
        $this->hasClass($output, 'i', 'fa-envelope');
        $this->assertHtml($output, "//span/i");
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
        $this->hasClass($output, 'div', 'field');
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->hasClass($output, 'div', 'has-addons');
        $this->hasClass($output, 'p', 'control');
        $this->hasClass($output, 'a', 'button');
        $this->hasClass($output, 'a', 'is-static');
        $this->hasClass($output, 'div', 'control');
        $this->hasClass($output, 'input', 'input');
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/p");
        $this->assertHtml($output, "//div/div/div/input");

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['suffix' => $this->form->addonButton('addon')]
        );
        $this->hasClass($output, 'div', 'field');
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->hasClass($output, 'div', 'has-addons');
        $this->hasClass($output, 'p', 'control');
        $this->hasClass($output, 'button', 'button');
        $this->hasClass($output, 'div', 'control');
        $this->hasClass($output, 'input', 'input');
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/p");
        $this->assertHtml($output, "//div/div/div/input");
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
        $this->hasClass($output, 'div', 'field');
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->hasClass($output, 'div', 'has-addons');
        $this->hasClass($output, 'p', 'control');
        $this->hasClass($output, 'a', 'button');
        $this->hasClass($output, 'a', 'is-static');
        $this->hasClass($output, 'div', 'control');
        $this->hasClass($output, 'input', 'input');
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/p");
        $this->assertHtml($output, "//div/div/div/input");

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['suffix' => $this->form->addonIcon('addon')]
        );
        $this->hasClass($output, 'div', 'field');
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->hasClass($output, 'div', 'has-addons');
        $this->hasClass($output, 'div', 'control');
        $this->hasClass($output, 'input', 'input');
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/div/input");

        $output = $this->form->input(
            'text',
            'label',
            'name',
            null,
            ['prefix' => $this->form->addonIcon('addon')]
        );
        $this->hasClass($output, 'div', 'field');
        $this->hasAttribute($output, 'label', 'for', 'label');
        $this->hasClass($output, 'div', 'has-addons');
        $this->hasClass($output, 'div', 'control');
        $this->hasClass($output, 'input', 'input');
        $this->assertHtml($output, "//div/label");
        $this->assertHtml($output, "//div/div/div/input");
    }
}
