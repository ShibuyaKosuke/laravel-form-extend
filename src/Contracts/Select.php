<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use Illuminate\Support\HtmlString;

/**
 * Interface Select
 * @package ShibuyaKosuke\LaravelFormExtend\Contracts
 * @codeCoverageIgnore
 */
interface Select
{
    /**
     * select
     * @param string $name
     * @param HtmlString|string $label
     * @param array $list
     * @param mixed $selected
     * @param array $selectAttrs
     * @param array $optionsAttrs
     * @param array $optgroupsAttrs
     * @return HtmlString
     */
    public function select(
        string $name,
        $label,
        array $list = [],
        $selected = null,
        array $selectAttrs = [],
        array $optionsAttrs = [],
        array $optgroupsAttrs = []
    ): HtmlString;

    /**
     * selectRange
     * @param string $name
     * @param HtmlString|string $label
     * @param mixed $begin
     * @param mixed $end
     * @param null $selected
     * @param array $options
     * @return HtmlString
     */
    public function selectRange(string $name, $label, $begin, $end, $selected = null, array $options = []): HtmlString;
}
