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
    public function addonButton(string $label, array $options = []);

    /**
     * Create an addon text element.
     * @param string $text
     * @param array $options
     * @return string
     */
    public function addonText(string $text, array $options = []);

    /**
     * Create an addon icon element.
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function addonIcon(string $icon, array $options = []);
}
