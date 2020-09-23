<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders\Addons;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use phpDocumentor\Reflection\Types\Callable_;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

/**
 * Class Text
 * @package ShibuyaKosuke\LaravelFormExtend\Builders\Addons
 */
class Text
{
    /**
     * @var array|\ArrayAccess|mixed
     */
    private $default;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $options;

    /**
     * Text constructor.
     * @param Application $app
     * @param callable $callback
     * @param string $text
     * @param array $options
     */
    public function __construct(Application $app, callable $callback, string $text, array $options = [])
    {
        $this->default = Arr::get($app['config']->get(ServiceProvider::KEY), 'default');
        $this->callback = $callback;
        $this->text = $text;
        $this->options = $options;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toHtml()
    {
        $html = call_user_func_array($this->callback, [$this->text, $this->options]);
        if ($html instanceof HtmlString) {
            return $html->toHtml();
        }
        throw new \Exception('Callback not return HtmlString.');
    }
}
