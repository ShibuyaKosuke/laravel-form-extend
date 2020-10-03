<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Checkbox
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Checkbox
{
    /**
     * checkbox
     * @param string $name
     * @param HtmlString|string|null $label
     * @param integer $value
     * @param null $checked
     * @param array $options
     * @return HtmlString
     */
    public function checkbox(string $name, $label = null, $value = 1, $checked = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|null $label
     * @param array $choices
     * @param array $checkedValues
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function checkboxes(
        string $name,
        $label = null,
        array $choices = [],
        array $checkedValues = [],
        bool $inline = false,
        array $options = []
    ): HtmlString;
}
