<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bulma;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class FormBuilderTest
 * @package ShibuyaKosuke\LaravelFormExtend\Test
 */
class BulmaTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var Bulma|FormBuilder form */
        $this->form = new Bulma($this->app, 'bulma');
    }

    public function testSomeInputHorizontal()
    {
        $this->setType(Bulma::HORIZONTAL);

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
        $this->setType(Bulma::VERTICAL);

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
        $this->setType(Bulma::VERTICAL);
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
        $this->setType(Bulma::HORIZONTAL);
        $name = 'input-name';
        $label = 'file';
        $type = 'file';
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/div/label[@for='$name']");
        $this->assertHtml($output, "//div/div/input[@name='$name']");

        $this->setType(Bulma::VERTICAL);
        $output = $this->form->file($name, $label);

        $this->input($output, $type, $name);
        $this->label($output, $name, $label);
        $this->assertHtml($output, "//div/label[@for='$name']");
        $this->assertHtml($output, "//div/input[@name='$name']");
    }

    public function testSelectHorizontal()
    {
        $this->setType(Bulma::HORIZONTAL);
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
        $this->setType(Bulma::VERTICAL);
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
}
