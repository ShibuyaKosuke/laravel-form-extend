<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
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
     * @param HtmlString $label
     * @param HtmlString $form
     * @param string $name name attribute
     * @return HtmlString
     */
    protected function formGroup($label, $form, $name)
    {
        $error = $this->getFieldError($name);
        $errorElements = ($error) ?
            $this->html->tag('div', $error, ['class' => $this->getHelpTextErrorClassName()]) :
            null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());

        if ($this->isHorizontal()) {
            $this->addFormElementClass($attributes, 'row');

            // label
            $this->addFormElementClass($labelAttributes, $this->getClassName('left_column_class'));
            $label = $this->html->tag('div', implode([$label]), $labelAttributes);

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
    public function input(string $type, string $name, $label = null, string $value = null, array $options = [])
    {
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
    public function withAddonForBootstrap4($inputElement, $options, string $name)
    {
        $prefix = str_replace(':class_name', 'input-group-prepend', $options['prefix'] ?? null);
        $suffix = str_replace(':class_name', 'input-group-append', $options['suffix'] ?? null);

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
    public function file(string $name, $label, $options = [])
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
    public function select(string $name, $label, $list = [], $selected = null, array $selectAttrs = [], array $optionsAttrs = [], array $optgroupsAttrs = [])
    {
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($selectAttrs, $this->getFormControlErrorClassName());
        }

        $this->addFormElementClass($selectAttrs, $this->getFormControlClassName());

        $optionsField = Arr::except($selectAttrs, ['suffix', 'prefix']);
        $inputElement = $this->form->select($name, $list, $selected, $optionsField, $optionsAttrs, $optgroupsAttrs);
        $inputElement = $this->withAddonForBootstrap4($inputElement, $selectAttrs, $name);

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($optionsField, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * @param string $label
     * @param array $options
     * @return string
     */
    public function addonButton($label, $options = []): string
    {
        $this->addFormElementClass($options, 'btn btn-outline-secondary');
        $button = $this->form->button($label, $options)->toHtml();
        return $this->html->tag('div', $button, ['class' => ':class_name'])->toHtml();
    }

    /**
     * @param string $text
     * @param array $options
     * @return string
     */
    public function addonText($text, $options = []): string
    {
        $this->addFormElementClass($options, 'input-group-text');
        $span = $this->html->tag('span', $text, $options)->toHtml();
        return $this->html->tag('div', $span, ['class' => ':class_name']);
    }

    /**
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function addonIcon($icon, $options = []): string
    {
        $this->addFormElementClass($options, 'input-group-text');
        $i = $this->html->tag('i', '', ['class' => $icon])->toHtml();
        $span = $this->html->tag('span', $i, $options)->toHtml();
        return $this->html->tag('div', $span, ['class' => ':class_name'])->toHtml();
    }
}
