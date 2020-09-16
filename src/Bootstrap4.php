<?php

namespace ShibuyaKosuke\LaravelFormExtend;

use Illuminate\Support\HtmlString;
use ShibuyaKosuke\LaravelFormExtend\Builders\FormBuilder;

/**
 * Class Bootstrap4
 * @package ShibuyaKosuke\LaravelFormExtend
 */
class Bootstrap4 extends FormBuilder
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
}
