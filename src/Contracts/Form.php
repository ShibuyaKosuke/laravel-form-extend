<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Form
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Form
{
    /**
     * Form open tag
     * @param array $options
     * @return HtmlString
     *
     */
    public function open(array $options = []): HtmlString;

    /**
     * Form open tag for horizontal.
     * @param array $options
     * @return HtmlString
     */
    public function horizontal(array $options = []): HtmlString;

    /**
     * Form open tag for vertical.
     * @param array $options
     * @return HtmlString
     */
    public function vertical(array $options = []): HtmlString;

    /**
     * Form open tag for inline.
     * @param array $options
     * @return HtmlString
     */
    public function inline(array $options = []): HtmlString;

    /**
     * Form close tag.
     * @return HtmlString
     */
    public function close(): HtmlString;
}
