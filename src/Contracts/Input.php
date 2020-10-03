<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Input
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Input
{
    /**
     * input
     * @param string $type
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return mixed
     */
    public function input(
        string $type,
        string $name,
        $label = null,
        string $value = null,
        array $options = []
    ): HtmlString;

    /**
     * hidden
     * @param string $name
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function hidden(string $name, $value = null, $options = []): HtmlString;

    /**
     * text
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function text(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function search(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function tel(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function url(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function email(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param array $options
     * @return HtmlString
     */
    public function password(string $name, $label, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function datetime(string $name, $label, $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function date(string $name, $label, $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function week(string $name, $label, $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function time(string $name, $label, $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function datetimeLocal(string $name, $label, $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function number(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function range(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param string|null $value
     * @param array $options
     * @return HtmlString
     */
    public function color(string $name, $label, string $value = null, array $options = []): HtmlString;

    /**
     * @param string $name
     * @param HtmlString|string|boolean|null $label
     * @param array $options
     * @return HtmlString
     */
    public function file(string $name, $label, array $options = []): HtmlString;
}
