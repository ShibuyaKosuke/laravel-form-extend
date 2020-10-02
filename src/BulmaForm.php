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
 * Class BulmaForm
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class BulmaForm extends FormBuilder
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
     * @param HtmlString|string $label
     * @param HtmlString $form
     * @param string $name name attribute
     * @return HtmlString
     */
    public function formGroupWithAddon($label, HtmlString $form, string $name): HtmlString
    {
        $error = $this->getFieldError($name);
        $errorElements = ($error) ?
            $this->html->tag('p', $error, ['class' => $this->getHelpTextErrorClassName()]) :
            null;

        $this->addFormElementClass($attributes, $this->getFormGroupClassName());

        if ($this->isHorizontal()) {
            if ($label) {
                $label = $this->wrapElement($label, 'field-label is-expanded is-normal');
            } else {
                $label = $this->wrapElement('', 'field-label is-normal');
            }
            $form = $this->wrapElement($form->toHtml(), 'field has-addons');
            $form = $this->wrapElement($form->toHtml() . $errorElements, 'field is-expanded');
            $form = $this->wrapElement($form, 'field-body');
            return $this->wrapElement(implode([$label, $form]), 'field is-horizontal');
        }

        $form = $this->wrapElement($form->toHtml(), 'field has-addons');
        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * Only use when BulmaForm support
     * @param HtmlString|string $inputElement
     * @param string|null $class
     * @return HtmlString
     */
    private function wrapElement($inputElement, string $class = null): HtmlString
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
     * @param string|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     * @throws Exception
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
        $inputElement = $this->form->input($type, $name, $value, $optionsField);
        $inputElement = $this->withAddon($inputElement, $options);

        if (isset($options['prefix']) || isset($options['suffix'])) {
            return $this->formGroupWithAddon(
                $this->label($name, $label),
                $inputElement,
                $name
            );
        }

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
     * @param HtmlString|string $inputElement
     * @param array $options
     * @return HtmlString
     * @throws Exception
     */
    public function withAddon(HtmlString $inputElement, array $options): HtmlString
    {
        $prefix = $options['prefix'] ?? null;

        $suffix = $options['suffix'] ?? null;

        if (is_null($prefix) && is_null($suffix)) {
            return $inputElement;
        }

        if ($prefix instanceof Text || $prefix instanceof Button) {
            $inputElement = $this->wrapElement($inputElement, 'control');
            return new HtmlString($prefix->toHtml() . $inputElement);
        }

        if ($suffix instanceof Text || $suffix instanceof Button) {
            $inputElement = $this->wrapElement($inputElement, 'control  is-expanded');
            return new HtmlString($inputElement . $suffix->toHtml());
        }

        $inputGroupClass = [];
        if ($prefix && $prefix instanceof Icon) {
            $prefix = str_replace(':class_name', 'is-left', $prefix->toHtml());
            $this->addFormElementClass($inputGroupClass, 'has-icons-left');
        }

        if ($suffix && $suffix instanceof Icon) {
            $suffix = str_replace(':class_name', 'is-right', $suffix->toHtml());
            $this->addFormElementClass($inputGroupClass, 'has-icons-right');
        }

        $this->addFormElementClass($inputGroupClass, 'control');
        $this->addFormElementClass($inputGroupClass, 'is-expanded');

        return $this->html->tag(
            'div',
            implode([$inputElement->toHtml(), $prefix, $suffix]),
            $inputGroupClass
        );
    }

    /**
     * select
     *
     * @param string $name
     * @param mixed|null $label
     * @param array $list
     * @param string|null $selected
     * @param array $selectAttrs
     * @param array $optionsAttrs
     * @param array $optgroupsAttrs
     * @return HtmlString
     * @throws Exception
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

        $options = Arr::except($selectAttrs, ['suffix', 'prefix']);

        $inputElement = $this->form->select($name, $list, $selected, $options, $optionsAttrs, $optgroupsAttrs);
        $inputElement = $this->withAddon($inputElement, $selectAttrs);

        if (isset($selectAttrs['prefix']) || isset($selectAttrs['suffix'])) {
            return $this->formGroupWithAddon(
                $this->label($name, $label),
                $inputElement,
                $name
            );
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
     * @return Button
     */
    public function addonButton(string $label, array $options = []): Button
    {
        $callback = function ($label, $options) {
            $this->addFormElementClass($options, 'button');
            $a = $this->html->tag('button', $label, $options);
            return $this->html->tag('p', $a->toHtml(), ['class' => 'control']);
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
            $this->addFormElementClass($options, 'button');
            $this->addFormElementClass($options, 'is-static');
            $a = $this->html->tag('a', $text, $options);
            return $this->html->tag('p', $a->toHtml(), ['class' => 'control']);
        };
        return new Text($callback, $text, $options);
    }

    /**
     * @param string $icon
     * @param array $options
     * @return Icon
     */
    public function addonIcon(string $icon, array $options = []): Icon
    {
        $callback = function (Builders\Icons\Icon $iconObject) {
            $this->addFormElementClass($iconClass, $iconObject->className());
            $i = $this->html->tag('i', '', $iconClass);
            return $this->html->tag('span', $i->toHtml(), ['class' => 'icon is-small :class_name']);
        };

        $iconObject = new Builders\Icons\Icon($this->app, $icon);
        return new Icon($callback, $iconObject, $options);
    }
}
