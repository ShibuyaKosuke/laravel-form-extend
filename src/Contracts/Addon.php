<?php

namespace ShibuyaKosuke\LaravelFormExtend\Contracts;

use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Button;
use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Icon;
use ShibuyaKosuke\LaravelFormExtend\Builders\Addons\Text;

/**
 * Interface Addon
 * @package ShibuyaKosuke\LaravelFormExtend\Builders
 * @codeCoverageIgnore
 */
interface Addon
{
    /**
     * Create an addon button element.
     * @param string $label
     * @param array $options
     * @return Button
     */
    public function addonButton(string $label, array $options = []): Button;

    /**
     * Create an addon text element.
     * @param string $text
     * @param array $options
     * @return Text
     */
    public function addonText(string $text, array $options = []): Text;

    /**
     * Create an addon icon element.
     * @param string $icon
     * @param array $options
     * @return Icon
     */
    public function addonIcon(string $icon, array $options = []): Icon;
}
