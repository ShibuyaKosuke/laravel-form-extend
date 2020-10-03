<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Textarea
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Textarea
{
    /**
     * textarea
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options
     * @return HtmlString
     */
    public function textarea(string $name, $label, $value = null, $options = []): HtmlString;
}
