<?php

namespace ShibuyaKosuke\LaravelFormExtend;

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
        return parent::input($type, $name, $label, $value, $options);
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
     * @param string $label
     * @param array $options
     * @return string
     */
    public function addonButton($label, $options = []): string
    {
        return '';
    }

    /**
     * @param string $text
     * @param array $options
     * @return string
     */
    public function addonText($text, $options = []): string
    {
        return '';
    }

    /**
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function addonIcon($icon, $options = []): string
    {
        return '';
    }
}
