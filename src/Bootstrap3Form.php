<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class Bootstrap3Form
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class Bootstrap3Form extends FormBuilder
{
    /**
     * get form group
     *
     * @param HtmlString $label Label text
     * @param HtmlString $form Form element
     * @param string $name Name attribute
     * @return HtmlString
     * @see FormBuilder::formGroup()
     */
    public function formGroup($label, $form, $name)
    {
        $error = $this->getFieldError($name);
        $errorElements = ($error) ?
            $this->html->tag('div', $error, ['class' => $this->getHelpTextErrorClassName()]) :
            null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());
        if ($error) {
            $this->addFormElementClass($attributes, $this->getFormGroupErrorClassName());
        }

        if ($this->isHorizontal()) {
            $this->addFormElementClass($formAttributes, $this->getClassName('right_column_class'));
            if (is_null($label)) {
                $this->addFormElementClass($formAttributes, $this->getClassName('left_column_offset_class'));
            }

            $form = $this->html->tag('div', $form->toHtml() . $errorElements, $formAttributes);
            return $this->html->tag('div', implode([$label, $form]), $attributes);
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * label
     *
     * @param string $name name
     * @param string|null $value value
     * @param array $options attributes
     * @param boolean $escape_html if escape true
     * @return HtmlString|null
     * @see FormBuilder::label()
     */
    public function label(string $name, $value = null, $options = [], $escape_html = true)
    {
        // Bootstrap3Form only
        $this->addFormElementClass($options, 'control-label');
        if ($this->isHorizontal()) {
            $this->addFormElementClass($options, $this->getClassName('left_column_class'));
        }
        return parent::label($name, $value, $options, $escape_html);
    }

    /**
     * Create a single checkbox element.
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text for label element
     * @param integer $value value
     * @param array|null $checked checked values array
     * @param boolean $inline true if inline
     * @param array $options attributes array
     * @return HtmlString
     * @see FormBuilder::checkboxElement()
     */
    public function checkboxElement(string $name, $label = null, $value = 1, $checked = null, $inline = false, array $options = [])
    {
        $this->addFormElementClass($options, $this->getCheckboxInputClassName($inline));
        $inputElement = $this->form->checkbox($name, $value, $checked, $options);

        $this->addFormElementClass($labelAttributes, $this->getCheckboxLabelClassName($inline));
        $labelElement = $this->html->tag('label', $inputElement->toHtml() . ' ' . $label, $labelAttributes);

        if ($inline) {
            return $labelElement;
        }

        $this->addFormElementClass($attributes, $this->getCheckboxWrapperClassName($inline));
        return $this->html->tag('div', $labelElement->toHtml(), $attributes);
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
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $this->form->input(__FUNCTION__, $name, null, $options),
            $name
        );
    }
}
