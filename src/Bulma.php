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
     * get form group
     *
     * @param string $label
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
                $label = $this->wrapElement($label->toHtml(), 'field-label is-normal');
            } else {
                $label = $this->wrapElement('', 'field-label is-normal');
            }
            $form = $this->wrapElement($form->toHtml(), 'control');
            $form = $this->wrapElement($form->toHtml() . $errorElements, 'field');
            $form = $this->wrapElement($form->toHtml(), 'field-body');
            return $this->wrapElement(implode([$label, $form]), 'field is-horizontal');
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * Only use when Bulma support
     * @param HtmlString|string $inputElement
     * @param string|null $class
     * @return HtmlString
     */
    private function wrapElement($inputElement, string $class = null)
    {
        $this->addFormElementClass($attributes, $class);
        return $this->html->tag('div', $inputElement, $attributes);
    }
}
