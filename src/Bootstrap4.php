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
            $this->addFormElementClass($formAttributes, $this->getClassName('right_column_class'));
            if (is_null($label)) {
                $this->addFormElementClass($formAttributes, $this->getClassName('left_column_offset_class'));
            }
            return $this->html->tag('div', implode([$label, $form]), $formAttributes);
        }

        return $this->html->tag('div', implode([$label, $form, $errorElements]), $attributes);
    }

    /**
     * label
     *
     * @param string $name name attribute
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @param boolean $escape_html
     * @return HtmlString|null
     */
    public function label(string $name, $value = null, $options = [], $escape_html = true)
    {
        if ($value === false) {
            return null;
        }
        if ($this->isHorizontal()) {
            $this->addFormElementClass($options, $this->getClassName('left_column_class'));
        }
        return $this->form->label($name, $value, $options, $escape_html);
    }
}
