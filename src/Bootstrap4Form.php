<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Button;
use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Icon;
use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Text;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class Bootstrap4Form
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class Bootstrap4Form extends FormBuilder
{
    /**
     * get form group
     *
     * @param HtmlString|string|null $label
     * @param HtmlString $form
     * @param string|null $name name attribute
     * @return HtmlString
     */
    protected function formGroup($label, HtmlString $form, ?string $name): HtmlString
    {
        $error = $this->getFieldError($name);
        $errorElements = ($error) ?
            $this->html->tag('div', $error, ['class' => $this->getHelpTextErrorClassName()]) :
            null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());

        if ($this->isHorizontal()) {
            $this->addFormElementClass($attributes, 'row');

            // label
            if (!is_null($label)) {
                $this->addFormElementClass($labelAttributes, $this->getClassName('left_column_class'));
                $label = $this->html->tag('div', implode([$label]), $labelAttributes);
            }

            $formAttributes = [];
            $this->addFormElementClass($formAttributes, $this->getClassName('right_column_class'));

            if (is_null($label)) {
                $this->addFormElementClass($formAttributes, $this->getClassName('left_column_offset_class'));
            }

            $form = $this->html->tag('div', implode([$form . $errorElements]), $formAttributes);
            return $this->html->tag('div', implode([$label, $form]), $attributes);
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * @param string $type
     * @param string $name
     * @param null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function input(
        string $type,
        string $name,
        $label = null,
        string $value = null,
        array $options = []
    ): HtmlString {
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }
        $this->addFormElementClass($options, $this->getFormControlClassName());

        $optionsField = Arr::except($options, ['suffix', 'prefix']);
        if (!Arr::has($optionsField, 'id')) {
            Arr::set($optionsField, 'id', $name);
        }
        $inputElement = $this->form->input($type, $name, $value, $optionsField);

        $inputElement = $this->withAddonForBootstrap4($inputElement, $options, $name);

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * @param HtmlString $inputElement
     * @param array $options
     * @param string $name
     * @return HtmlString
     */
    public function withAddonForBootstrap4(HtmlString $inputElement, array $options, string $name): HtmlString
    {
        $prefix = str_replace(
            ':class_name',
            'input-group-prepend',
            isset($options['prefix']) ? $options['prefix']->toHtml() : null
        );
        $suffix = str_replace(
            ':class_name',
            'input-group-append',
            isset($options['suffix']) ? $options['suffix']->toHtml() : null
        );

        if ($prefix || $suffix) {
            $inputGroupClass = $this->addFormElementClass($inputGroupClass, 'input-group');

            if ($this->getFieldError($name)) {
                $inputGroupClass = $this->addFormElementClass($inputGroupClass, 'is-invalid');
            }
            return $this->html->tag(
                'div',
                implode([$prefix, $inputElement->toHtml(), $suffix]),
                $inputGroupClass
            );
        }
        return $inputElement;
    }

    /**
     * input::file
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $options attributes array
     * @return HtmlString
     */
    public function file(string $name, $label, $options = []): HtmlString
    {
        $this->addFormElementClass($options, 'form-control-file');

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $this->form->input(__FUNCTION__, $name, null, $options),
            $name
        );
    }

    /**
     * select
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $list
     * @param mixed|null $selected
     * @param array $selectAttrs
     * @param array $optionsAttrs
     * @param array $optgroupsAttrs
     * @return HtmlString
     */
    public function select(
        string $name,
        $label,
        $list = [],
        $selected = null,
        array $selectAttrs = [],
        array $optionsAttrs = [],
        array $optgroupsAttrs = []
    ): HtmlString {
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($selectAttrs, $this->getFormControlErrorClassName());
        }

        $this->addFormElementClass($selectAttrs, $this->getFormControlClassName());

        $optionsField = Arr::except($selectAttrs, ['suffix', 'prefix']);
        $inputElement = $this->form->select($name, $list, $selected, $optionsField, $optionsAttrs, $optgroupsAttrs);
        $inputElement = $this->withAddonForBootstrap4($inputElement, $selectAttrs, $name);

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * @param string $label
     * @param array $options
     * @return Button
     */
    public function addonButton(string $label, array $options = []): Button
    {
        $callback = function ($label, $options) {
            $this->addFormElementClass($options, 'btn btn-outline-secondary');
            $button = $this->form->submit($label, $options)->toHtml();
            return $this->html->tag('div', $button, ['class' => ':class_name']);
        };
        array_merge(['type' => 'submit'], $options);
        return new Button($callback, $label, $options);
    }

    /**
     * @param string $text
     * @param array $options
     * @return Text
     */
    public function addonText(string $text, array $options = []): Text
    {
        $callback = function (string $text, array $options) {
            $this->addFormElementClass($options, 'input-group-text');
            $span = $this->html->tag('span', $text, $options)->toHtml();
            return $this->html->tag('div', $span, ['class' => ':class_name']);
        };
        return new Text($callback, $text, $options);
    }

    /**
     * @param string $icon
     * @param array $options
     * @return Icon
     * @throws Exception
     */
    public function addonIcon(string $icon, array $options = []): Icon
    {
        $callback = function (Builders\Icons\Icon $iconObject) {
            $this->addFormElementClass($options, 'input-group-text');
            $this->addFormElementClass($iconClass, $iconObject->className());
            $i = $this->html->tag('i', '', $iconClass)->toHtml();
            $span = $this->html->tag('span', $i, $options)->toHtml();
            return $this->html->tag('div', $span, ['class' => ':class_name']);
        };

        $iconObject = new Builders\Icons\Icon($this->app, $icon);
        return new Icon($callback, $iconObject, $options);
    }
}
