<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

/**
 * Interface Addon
 * @package ShibuyaKosuke\LaravelFormExtend\Builders
 */
interface Addon
{
    /**
     * Create an addon button element.
     * @param string $label
     * @param array $options
     * @return string
     */
    public function addonButton($label, $options = []): string;

    /**
     * Create an addon text element.
     * @param string $text
     * @param array $options
     * @return string
     */
    public function addonText($text, $options = []): string;

    /**
     * Create an addon icon element.
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function addonIcon($icon, $options = []): string;
}
