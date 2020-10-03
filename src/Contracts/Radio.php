<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Radio
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Radio
{
    /**
     * radio
     * @param string $name
     * @param HtmlString|string|null $label
     * @param string|null $value
     * @param string|null $checked
     * @param array|null $options
     * @return HtmlString
     */
    public function radio(string $name, $label = null, $value = null, $checked = null, array $options = []): HtmlString;

    /**
     * radios
     * @param string $name
     * @param HtmlString|string|null $label
     * @param array $choices
     * @param string|integer|null $checkedValue
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function radios(
        string $name,
        $label = null,
        array $choices = [],
        $checkedValue = null,
        bool $inline = false,
        array $options = []
    ): HtmlString;
}
