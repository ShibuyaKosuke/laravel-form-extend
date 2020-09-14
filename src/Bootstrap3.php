<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class Bootstrap3
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class Bootstrap3 extends FormBuilder
{
    /**
     * get form group
     *
     * @param $label
     * @param $form
     * @param string $name
     * @return HtmlString
     */
    public function formGroup($label, $form, $name)
    {
        $error = $this->getFieldError($name);
        $errorElements = ($error) ? $this->html->tag('div', $error, ['class' => $this->getHelpTextErrorClassName()]) : null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());
        if ($error) {
            $this->addFormElementClass($attributes, $this->getFormGroupErrorClassName());
        }

        if ($this->isHorizontal()) {
            return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * @param string $name
     * @param null $value
     * @param array $options
     * @param bool $escape_html
     * @return HtmlString|null
     */
    public function label(string $name, $value = null, $options = [], $escape_html = true)
    {
        // Bootstrap3 only
        $this->addFormElementClass($options, 'control-label');
        return parent::label($name, $value, $options, $escape_html);
    }

    public function checkboxElement($name, $label = null, $value = 1, $checked = null, $inline = false, array $options = [])
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
}