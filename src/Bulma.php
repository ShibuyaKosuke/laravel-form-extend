<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class Bulma
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class Bulma extends FormBuilder
{
    /**
     * input
     *
     * @param string $type
     * @param string $name
     * @param null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::input()
     */
    public function input(string $type, string $name, $label = null, string $value = null, array $options = [])
    {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        $inputElement = $this->wrapElement($this->form->input($type, $name, $value, $options));

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * input::submit
     *
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::submit()
     */
    public function submit(string $value = null, $options = [])
    {
        $this->addFormElementClass($options, $this->getButtonClass());

        $inputElement = $this->form->submit($value, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(
            null,
            $inputElement,
            null
        );
    }

    /**
     * input::button
     *
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::button()
     */
    public function button(string $value = null, $options = [])
    {
        $this->addFormElementClass($options, $this->getButtonClass());

        $inputElement = $this->form->button($value, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(
            null,
            $inputElement,
            null
        );
    }

    /**
     * select
     *
     * @param string $name
     * @param mixed|null $label
     * @param array $list
     * @param mixed|null $selected
     * @param array $selectAttributes
     * @param array $optionsAttributes
     * @param array $optgroupsAttributes
     * @return HtmlString
     * @see FormBuilder::select()
     */
    public function select(
        string $name,
        $label,
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        $this->addFormElementClass($selectAttributes, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($selectAttributes, $this->getFormControlErrorClassName());
        }

        $inputElement = $this->form
            ->select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);

        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * selectRange
     *
     * @param string $name
     * @param string|null $label
     * @param string|integer $begin
     * @param string|integer$end
     * @param string|integer|null $selected
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::selectRange()
     */
    public function selectRange(string $name, $label, $begin, $end, $selected = null, $options = [])
    {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        $inputElement = $this->form->selectRange($name, $begin, $end, $selected, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * textarea
     *
     * @param string $name
     * @param mixed|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::textarea()
     */
    public function textarea(string $name, $label, $value = null, $options = [])
    {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        $inputElement = $this->form->textarea($name, $value, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * Create a checkbox input.
     *
     * @param string $name
     * @param mixed|null $label
     * @param integer $value
     * @param mixed|null $checked
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::checkbox()
     */
    public function checkbox(string $name, $label = null, $value = 1, $checked = null, array $options = [])
    {
        $inputElement = $this->checkboxElement($name, $label, $value, $checked, false, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(null, $inputElement, $name);
    }

    /**
     * Create a radio input.
     *
     * @param string $name
     * @param mixed $label
     * @param mixed $value
     * @param mixed $checked
     * @param array $options
     * @return HtmlString
     * @see FormBuilder::radio()
     */
    public function radio(string $name, $label = null, $value = null, $checked = null, array $options = [])
    {
        $inputElement = $this->radioElement($name, $label, $value, $checked, false, $options);
        $inputElement = $this->wrapElement($inputElement);

        return $this->formGroup(null, $inputElement, $name);
    }

    /**
     * Only use when Bulma support
     * @param HtmlString|string $inputElement
     * @return HtmlString
     */
    private function wrapElement($inputElement)
    {
        return $this->html->tag('div', $inputElement->toHtml(), ['class' => 'control']);
    }
}
