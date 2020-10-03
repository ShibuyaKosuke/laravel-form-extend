<?php

namespace ShibuyaKosuke\LaravelFormExtend\Test;

use Collective\Html\HtmlBuilder;
use ShibuyaKosuke\LaravelFormExtend\Bootstrap4Form;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;
use ShibuyaKosuke\LaravelFormExtend\Exceptions\FormExtendException;

class FormBuilderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['html'] = \Mockery::mock(HtmlBuilder::class);

        /** @var Bootstrap4Form|FormBuilder form */
        $this->form = new Bootstrap4Form($this->app, 'bootstrap4');
    }

    public function horizontal($output)
    {
        $config = $this->getConfigClass();
        $classes = explode(' ', implode(' ', [$config['left_column_class'], $config['right_column_class']]));
        foreach ($classes as $class) {
            $this->hasClass($output, 'div', $class);
        }
    }

    public function testLinkCss(): void
    {
        $output = $this->form->linkCss()->toHtml();
        $this->assertHtml($output, '//link[@type="text/css"]');
        $this->assertHtml($output, '//link[@href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"]');
    }

    public function testUndefinedMethodCall(): void
    {
        $this->expectException(FormExtendException::class);
        $this->form->undefined();
    }

    public function testVertical()
    {
        $output = $this->form->vertical();
        $this->hasClass($output, 'form', 'bootstrap4');
    }

    public function testIsVertical()
    {
        $this->form->vertical();
        $output = $this->form->isVertical();
        $this->assertTrue($output);
    }

    public function testInline()
    {
        $output = $this->form->inline();
        $this->hasClass($output, 'form', 'form-inline');
    }

    public function testIsInLine()
    {
        $this->form->inline();
        $output = $this->form->isInline();
        $this->assertTrue($output);
    }

    public function testClose()
    {
        $this->form->close();
        $output = $this->form->isVertical();
        $this->assertTrue($output);
    }
}