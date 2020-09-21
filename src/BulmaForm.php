<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class BulmaForm
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class BulmaForm extends FormBuilder
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
            $this->html->tag('p', $error, ['class' => $this->getHelpTextErrorClassName()]) :
            null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());

        if ($this->isHorizontal()) {
            if ($label) {
                $label = $this->wrapElement($label, 'field-label is-normal');
            } else {
                $label = $this->wrapElement('', 'field-label is-normal');
            }
            $form = $this->wrapElement($form, 'control');
            $form = $this->wrapElement($form->toHtml() . $errorElements, 'field');
            $form = $this->wrapElement($form, 'field-body');
            return $this->wrapElement(implode([$label, $form]), 'field is-horizontal');
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * Only use when BulmaForm support
     * @param HtmlString|string $inputElement
     * @param string|null $class
     * @return HtmlString
     */
    private function wrapElement($inputElement, string $class = null)
    {
        if ($inputElement instanceof HtmlString) {
            $inputElement = $inputElement->toHtml();
        }
        $this->addFormElementClass($attributes, $class);
        return $this->html->tag('div', $inputElement, $attributes);
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
        $inputElement = $this->form->input($type, $name, $value, $optionsField);
        $inputElement = $this->withAddon($inputElement, $options);

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
     * @return HtmlString
     */
    public function withAddon($inputElement, $options)
    {
        $prefix = $options['prefix'] ?? null;

        $suffix = $options['suffix'] ?? null;

        if (is_null($prefix) && is_null($suffix)) {
            return $inputElement;
        }

        $this->addFormElementClass($inputGroupClass, 'control');

        if ($prefix) {
            $position = 'right';
            $iconPosition = 'is-' . $position;
            $prefix = str_replace(':class_name', $iconPosition, $prefix);
            $this->addFormElementClass($inputGroupClass, 'has-icons-right');
        }

        if ($suffix) {
            $position = 'left';
            $iconPosition = 'is-' . $position;
            $suffix = str_replace(':class_name', $iconPosition, $suffix);
            $this->addFormElementClass($inputGroupClass, 'has-icons-left');
        }

        return $this->html->tag(
            'div',
            implode([$inputElement->toHtml(), $prefix, $suffix]),
            $inputGroupClass
        );
    }

    /**
     * @param string $label
     * @param array $options
     * @return string
     */
    public function addonButton($label, $options = []): string
    {
        // @todo
        return '';
    }

    /**
     * @param string $text
     * @param array $options
     * @return string
     */
    public function addonText($text, $options = []): string
    {
        // @todo
        return '';
    }

    /**
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function addonIcon($icon, $options = []): string
    {
        $this->addFormElementClass($iconClass, $icon);
        $i = $this->html->tag('i', '', $iconClass);
        return $this->html->tag('span', $i->toHtml(), ['class' => 'icon is-small :class_name']);
    }
}
