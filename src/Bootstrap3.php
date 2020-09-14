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
     * @see FormBuilder::formGroup()
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
     * label
     *
     * @param string $name
     * @param null $value
     * @param array $options
     * @param bool $escape_html
     * @return HtmlString|null
     * @see FormBuilder::label()
     */
    public function label(string $name, $value = null, $options = [], $escape_html = true)
    {
        // Bootstrap3 only
        $this->addFormElementClass($options, 'control-label');
        return parent::label($name, $value, $options, $escape_html);
    }

    /**
     * Create a single checkbox element.
     *
     * @param string $name
     * @param mixed|null $label
     * @param int $value
     * @param mixed|null $checked
     * @param bool $inline
     * @param array $options
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
}