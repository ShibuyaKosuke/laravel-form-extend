<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Button
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Button
{
    /**
     * button
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function button(string $value = null, array $options = []): HtmlString;

    /**
     * submit
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function submit(string $value = null, array $options = []): HtmlString;
}
