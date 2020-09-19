<?php

namespace ShibuyaKosuke\LaravelFormExtend;

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
