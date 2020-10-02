<?php

namespace ShibuyaKosuke\LaravelFormExtend\Builders;

use ArrayAccess;
use BadMethodCallException;
use Collective\Html\FormBuilder as CollectiveFormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use DateTime;
use Illuminate\Support\ViewErrorBag;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Addon;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Button;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Checkbox;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Form;
use ShibuyaKosuke\LaravelFormExtend\Contracts\HelpText;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Input;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Radio;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Select;
use ShibuyaKosuke\LaravelFormExtend\Contracts\Textarea;
use ShibuyaKosuke\LaravelFormExtend\Exceptions\FormExtendException;
use ShibuyaKosuke\LaravelFormExtend\Providers\ServiceProvider;

/**
 * Class FormBuilder
 * @package ShibuyaKosuke\LaravelFormExtend\Builders
 */
abstract class FormBuilder implements Addon, Input, Form, Button, Checkbox, Radio, HelpText, Select, Textarea
{
    /**
     * Vertical form
     */
    public const VERTICAL = 1;

    /**
     * Horizontal form
     */
    public const HORIZONTAL = 2;

    /**
     * Inline form
     */
    public const INLINE = 3;

    /**
     * @var integer $form_type form style
     */
    protected $form_type = self::VERTICAL;

    /**
     * @var Application $app
     */
    protected $app;

    /**
     * @var Collection $config
     */
    protected $config;

    /**
     * @var string default css framework
     */
    protected $default;

    /**
     * @var HtmlBuilder $html LaravelCollective/HtmlBuilder
     */
    protected $html;

    /**
     * @var CollectiveFormBuilder $form LaravelCollective/FormBuilder
     */
    protected $form;

    /**
     * The errorBag that is used for validation (multiple forms).
     *
     * @var string
     */
    protected $errorBag;

    /**
     * FormBuilder constructor.
     * @param Application $app
     * @param null $default
     */
    public function __construct(Application $app, $default = null)
    {
        /** @var Application app */
        $this->app = $app;
        $config = $this->app->config->get(ServiceProvider::KEY);
        $this->config = new Collection($config);
        $this->default = ($default) ?: $this->config->get('default', $default);

        if (is_null($this->html)) {
            $this->html = new HtmlBuilder(
                $app['url'],
                $app['view']
            );
        }
        if (is_null($this->form)) {
            $this->form = new CollectiveFormBuilder(
                $this->html,
                $app['url'],
                $app['view'],
                $app['session.store']->token(),
                $app['request']
            );
            $this->form->setSessionStore($app['session.store']);
        }
    }

    /**
     * set form style
     *
     * @param integer $type form style
     * @return void
     */
    protected function setType(int $type): void
    {
        $this->form_type = $type;
    }

    /**
     * get selected css framework name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->default;
    }

    /**
     * @return HtmlString
     */
    public function linkCss(): HtmlString
    {
        return $this->html->style($this->css());
    }

    /**
     * @return array|ArrayAccess|mixed
     */
    public function css()
    {
        return Arr::get($this->config->get('css'), $this->name());
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $method
     * @param array|null $parameters
     * @return mixed
     * @throws FormExtendException
     */
    public function __call(string $method, array $parameters = [])
    {
        try {
            return call_user_func_array([$this->form, $method], $parameters);
        } catch (BadMethodCallException $e) {
            throw new FormExtendException($e->getMessage());
        }
    }

    /**
     * Form open tag
     *
     * @param array $options attributes array
     * @return HtmlString
     */
    public function open(array $options = []): HtmlString
    {
        if (array_key_exists('error_bag', $options)) {
            $this->setErrorBag($options['error_bag']);
        }

        $this->addFormElementClass($options, $this->name());

        return $this->form->open($options);
    }

    /**
     * Form open tag for horizontal form
     *
     * @param array $options attributes array
     * @return HtmlString
     */
    public function vertical($options = []): HtmlString
    {
        $this->setType(self::VERTICAL);
        return $this->open($options);
    }

    /**
     * check in horizontal form
     *
     * @return boolean
     */
    public function isVertical(): bool
    {
        return $this->form_type === self::VERTICAL;
    }

    /**
     * Form open tag for horizontal form
     *
     * @param array $options attributes array
     * @return HtmlString
     */
    public function horizontal($options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getHorizontalFormClassName());
        $this->setType(self::HORIZONTAL);
        return $this->open($options);
    }

    /**
     * check in horizontal form
     *
     * @return boolean
     */
    public function isHorizontal(): bool
    {
        return $this->form_type === self::HORIZONTAL;
    }

    /**
     * Form open tag for inline form
     *
     * @param array $options attributes array
     * @return HtmlString
     */
    public function inline($options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getInlineFormClassName());
        $this->setType(self::INLINE);
        return $this->open($options);
    }

    /**
     * check in inline form
     *
     * @return boolean
     */
    public function isInline(): bool
    {
        return $this->form_type === self::INLINE;
    }

    /**
     * Form close tag
     *
     * @return HtmlString|string
     */
    public function close(): HtmlString
    {
        $this->setType(self::VERTICAL);
        return $this->form->close();
    }

    /**
     * Output html tags
     *
     * @param mixed ...$html
     * @return string
     * @required php >=5.6
     */
    protected function toHtml(...$html): string
    {
        return (new HtmlString(implode($html)))->toHtml();
    }

    /**
     * get form group
     *
     * @param HtmlString|string|null $label
     * @param HtmlString $form
     * @param string|null $name name attribute
     * @return HtmlString
     */
    abstract protected function formGroup($label, HtmlString $form, ?string $name): HtmlString;

    /**
     * label
     *
     * @param string $name name attribute
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @param boolean $escape_html
     * @return HtmlString|null
     */
    public function label(string $name, $value = null, $options = [], $escape_html = true)
    {
        if ($value === false) {
            return null;
        }
        if (is_array($value) && array_key_exists('html', $value)) {
            return $this->form->label($name, (new HtmlString($value['html']))->toHtml(), $options, false);
        }
        return $this->form->label($name, $value, $options, $escape_html);
    }

    /**
     * @param HtmlString $inputElement
     * @param array $options
     * @return HtmlString
     */
    public function withAddon(HtmlString $inputElement, array $options): HtmlString
    {
        $prefix = isset($options['prefix']) ? $options['prefix']->toHtml() : null;

        $suffix = isset($options['suffix']) ? $options['suffix']->toHtml() : null;

        if ($prefix || $suffix) {
            $inputGroupClass = $this->addFormElementClass($inputGroupClass, 'input-group');
            return $this->html->tag(
                'div',
                implode([$prefix, $inputElement->toHtml(), $suffix]),
                $inputGroupClass
            );
        }
        return $inputElement;
    }

    /**
     * input
     *
     * @param string $type
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value
     * @param array $options attributes array
     * @return HtmlString
     */
    public function input(
        string $type,
        string $name,
        $label = null,
        ?string $value = null,
        array $options = []
    ): HtmlString {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        $optionsField = Arr::except($options, ['suffix', 'prefix']);
        $inputElement = $this->form->input($type, $name, $value, $optionsField);
        $inputElement = $this->withAddon($inputElement, $options);

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * input::password
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $options attributes array
     * @return HtmlString
     */
    public function password(string $name, $label = null, array $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, '', $options);
    }

    /**
     * input::range
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function range(string $name, $label = null, ?string $value = null, array $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::hidden
     *
     * @param string $name name attribute
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function hidden(string $name, $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, false, $value, $options);
    }

    /**
     * input::number
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function number(string $name, $label = null, ?string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::text
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function text(string $name, $label, ?string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::search
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function search(string $name, $label, ?string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::tel
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function tel(string $name, $label, string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::email
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function email(string $name, $label, string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::date
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param DateTime|string|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function date(string $name, $label, $value = null, $options = []): HtmlString
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::datetime
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param DateTime|mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function datetime(string $name, $label, $value = null, $options = []): HtmlString
    {
        if ($value instanceof DateTime) {
            $value = $value->format(DateTime::RFC3339);
        }

        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::datetime-local
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param DateTime|mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function datetimeLocal(string $name, $label, $value = null, $options = []): HtmlString
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return $this->input('datetime-local', $name, $label, $value, $options);
    }

    /**
     * input::time
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param DateTime|mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function time(string $name, $label, $value = null, $options = []): HtmlString
    {
        if ($value instanceof DateTime) {
            $value = $value->format('H:i');
        }

        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::url
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function url(string $name, $label, string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::week
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param DateTime|mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function week(string $name, $label, $value = null, $options = []): HtmlString
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-\WW');
        }

        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::file
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $options attributes array
     * @return HtmlString
     */
    public function file(string $name, $label, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, null, $options);
    }

    /**
     * input::color
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param mixed|null $value value property
     * @param array $options attributes array
     * @return HtmlString
     */
    public function color(string $name, $label, string $value = null, $options = []): HtmlString
    {
        return $this->input(__FUNCTION__, $name, $label, $value, $options);
    }

    /**
     * input::submit
     *
     * @param string|null $value value property
     * @param array $options
     * @return HtmlString
     */
    public function submit(string $value = null, $options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getButtonClass());

        return $this->formGroup(
            null,
            $this->form->submit($value, $options),
            null
        );
    }

    /**
     * input::button
     *
     * @param string|null $value value property
     * @param array $options
     * @return HtmlString
     */
    public function button(string $value = null, $options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getButtonClass());

        return $this->formGroup(
            null,
            $this->form->button($value, $options),
            null
        );
    }

    /**
     * textarea
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param string|null $value value property
     * @param array $options
     * @return HtmlString
     */
    public function textarea(string $name, $label, $value = null, $options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $this->form->textarea($name, $value, $options),
            $name
        );
    }

    /**
     * select
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $list
     * @param mixed|null $selected
     * @param array $selectAttrs
     * @param array $optionsAttrs
     * @param array $optgroupsAttrs
     * @return HtmlString
     */
    public function select(
        string $name,
        $label,
        $list = [],
        $selected = null,
        array $selectAttrs = [],
        array $optionsAttrs = [],
        array $optgroupsAttrs = []
    ): HtmlString {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        $this->addFormElementClass($selectAttrs, $this->getFormControlClassName());

        $optionsField = Arr::except($selectAttrs, ['suffix', 'prefix']);
        $inputElement = $this->form->select($name, $list, $selected, $optionsField, $optionsAttrs, $optgroupsAttrs);
        $inputElement = $this->withAddon($inputElement, $selectAttrs);

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($optionsField, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $inputElement,
            $name
        );
    }

    /**
     * selectRange
     *
     * @param string $name name attribute
     * @param string|null $label inner text label element
     * @param string|integer $begin
     * @param string|integer $end
     * @param string|integer|null $selected
     * @param array $options
     * @return HtmlString
     */
    public function selectRange(string $name, $label, $begin, $end, $selected = null, $options = []): HtmlString
    {
        $this->addFormElementClass($options, $this->getFormControlClassName());

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($options, $this->getFormControlErrorClassName());
        }

        return $this->formGroup(
            $this->label($name, $label),
            $this->form->selectRange($name, $begin, $end, $selected, $options),
            $name
        );
    }

    /**
     * Create a checkbox input.
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param integer $value value property
     * @param mixed|null $checked
     * @param array $options
     * @return HtmlString
     */
    public function checkbox(string $name, $label = null, $value = 1, $checked = null, array $options = []): HtmlString
    {
        $inputElement = $this->checkboxElement($name, $label, $value, $checked, false, $options);

        return $this->formGroup(null, $inputElement, $name);
    }

    /**
     * Create a single checkbox element.
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param integer $value value property
     * @param mixed|null $checked
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function checkboxElement(
        string $name,
        $label = null,
        $value = 1,
        $checked = null,
        $inline = false,
        array $options = []
    ): HtmlString {
        $this->addFormElementClass($options, $this->getCheckboxInputClassName($inline));
        $inputElement = $this->form->checkbox($name, $value, $checked, $options);

        $this->addFormElementClass($labelAttributes, $this->getCheckboxLabelClassName($inline));
        $labelElement = $this->html->tag('label', $inputElement->toHtml() . ' ' . $label, $labelAttributes);

        $this->addFormElementClass($attributes, $this->getCheckboxWrapperClassName($inline));
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($attributes, $this->getFormControlErrorClassName());
        }
        return $this->html->tag('div', $labelElement->toHtml(), $attributes);
    }

    /**
     * Create a collection of checkboxes.
     *
     * @param string $name name attribute
     * @param mixed|null $label inner text label element
     * @param array $choices
     * @param array $checkedValues
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function checkboxes(
        string $name,
        $label = null,
        $choices = [],
        $checkedValues = [],
        $inline = false,
        array $options = []
    ): HtmlString {
        $elements = '';
        foreach ($choices as $value => $choiceLabel) {
            $checked = in_array($value, (array)$checkedValues);
            $elements .= $this->checkboxElement($name . '[]', $choiceLabel, $value, $checked, $inline, $options);
        }
        $wrapperOptions = [];
        $labelElement = $label;

        if ($this->isHorizontal()) {
            $this->addFormElementClass($labelOptions, $this->getClassName('left_column_class'));
            $labelElement = $this->html->tag('div', $label, $labelOptions);
        }
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($wrapperOptions, $this->getFormControlErrorClassName());
        }
        $wrapperElement = $this->html->tag('div', $elements, $wrapperOptions);
        return $this->formGroup($labelElement, $wrapperElement, $name);
    }

    /**
     * Create a radio input.
     *
     * @param string $name name attribute
     * @param mixed $label
     * @param mixed $value value property
     * @param mixed $checked
     * @param array $options
     * @return HtmlString
     */
    public function radio(string $name, $label = null, $value = null, $checked = null, array $options = []): HtmlString
    {
        $inputElement = $this->radioElement($name, $label, $value, $checked, false, $options);

        return $this->formGroup(null, $inputElement, $name);
    }

    /**
     * Create a single radio input.
     *
     * @param string $name name attribute
     * @param mixed $label
     * @param mixed $value value property
     * @param mixed $checked
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function radioElement(
        string $name,
        $label = null,
        $value = null,
        $checked = null,
        $inline = false,
        array $options = []
    ): HtmlString {
        $this->addFormElementClass($options, $this->getRadioInputClassName($inline));
        $inputElement = $this->form->radio($name, $value, $checked, $options);

        $this->addFormElementClass($labelAttributes, $this->getRadioLabelClassName($inline));
        $labelElement = $this->html->tag('label', $inputElement->toHtml() . ' ' . $label, $labelAttributes);

        $this->addFormElementClass($attributes, $this->getRadioWrapperClassName($inline));
        if ($this->getFieldError($name)) {
            $this->addFormElementClass($attributes, $this->getFormControlErrorClassName());
        }
        return $this->html->tag('div', $labelElement->toHtml(), $attributes);
    }

    /**
     * Create a collection of radio inputs.
     *
     * @param string $name name attribute
     * @param mixed $label
     * @param array $choices
     * @param mixed $checkedValue
     * @param boolean $inline
     * @param array $options
     * @return HtmlString
     */
    public function radios(
        string $name,
        $label = null,
        $choices = [],
        $checkedValue = null,
        $inline = false,
        array $options = []
    ): HtmlString {
        $elements = '';
        foreach ($choices as $value => $choiceLabel) {
            $checked = $value === $checkedValue;
            $elements .= $this->radioElement($name, $choiceLabel, $value, $checked, $inline, $options);
        }
        $wrapperOptions = [];
        $labelElement = $label;

        if ($this->isHorizontal()) {
            $this->addFormElementClass($labelOptions, $this->getClassName('left_column_class'));
            $labelElement = $this->html->tag('div', $label, $labelOptions);
        }

        if ($this->getFieldError($name)) {
            $this->addFormElementClass($wrapperOptions, $this->getFormControlErrorClassName());
        }
        $wrapperElement = $this->html->tag('div', $elements, $wrapperOptions);

        return $this->formGroup($labelElement, $wrapperElement, $name);
    }

    /**
     * Build class names for form element
     *
     * @param array|null $options form element attributes
     * @param string $value class name to be add
     * @return mixed
     */
    protected function addFormElementClass(?array &$options, string $value)
    {
        if (!Arr::has($options, 'class')) {
            Arr::set($options, 'class', []);
        }
        if (is_string($options['class'])) {
            $options['class'] = explode(' ', $options['class']);
        }
        if ($value !== '' && !in_array($value, $options['class'], true)) {
            $options['class'][] = $value;
        }
        $options['class'] = array_unique($options['class']);
        return $options;
    }

    /**
     * Get the error bag.
     *
     * @return string
     */
    protected function getErrorBag(): string
    {
        return $this->errorBag ?: 'default';
    }

    /**
     * Set the error bag.
     *
     * @param string $errorBag
     * @return void
     */
    protected function setErrorBag(string $errorBag): void
    {
        $this->errorBag = $errorBag;
    }

    /**
     * Flatten arrayed field names to work with the validator, including removing "[]",
     * and converting nested arrays like "foo[bar][baz]" to "foo.bar.baz".
     *
     * @param string|null $field
     * @return string
     */
    protected function flattenFieldName(?string $field): string
    {
        return preg_replace_callback("/\[(.*)]/U", function ($matches) {
            if (!empty($matches[1]) || $matches[1] === '0') {
                return "." . $matches[1];
            }
            return null;
        }, $field);
    }

    /**
     * Get the MessageBag of errors that is populated by the
     * validator.
     *
     * @return ViewErrorBag|null
     */
    public function getErrors(): ?ViewErrorBag
    {
        return $this->form->getSessionStore()->get('errors');
    }

    /**
     * Get the first error for a given field, using the provided
     * format, defaulting to the normal Bootstrap 3 format.
     *
     * @param string|null $field
     * @return string|null
     */
    protected function getFieldError(?string $field = null): ?string
    {
        $field = $this->flattenFieldName($field);

        if ($this->getErrors()) {
            $errorBag = ($this->getErrorBag()) ? $this->getErrors()->{$this->getErrorBag()} : $this->getErrors();
            if ($errorBag) {
                return $errorBag->first($field, ':message');
            }
        }
        return null;
    }

    /**
     * get form element class name
     *
     * @param string $class
     * @return array|ArrayAccess|mixed
     */
    protected function getClassName(string $class)
    {
        return Arr::get($this->config, sprintf('class_name.%s.%s', $this->name(), $class)) ?: '';
    }

    /**
     * form element class name
     *
     * @return string
     */
    protected function getFormControlClassName(): string
    {
        return $this->getClassName('form_control');
    }

    /**
     * form group class name
     *
     * @return string
     */
    protected function getFormGroupClassName(): string
    {
        return $this->getClassName('form_group');
    }

    /**
     * form horizontal class name
     *
     * @return string
     */
    protected function getHorizontalFormClassName(): string
    {
        return $this->getClassName('horizontal');
    }

    /**
     * form inline class name
     *
     * @return string
     */
    protected function getInlineFormClassName(): string
    {
        return $this->getClassName('inline');
    }

    /**
     * form element on error class name
     *
     * @return string
     */
    protected function getFormGroupErrorClassName(): string
    {
        return $this->getClassName('form_group_error');
    }

    /**
     * form element on error class name
     *
     * @return string
     */
    protected function getFormControlErrorClassName(): string
    {
        return $this->getClassName('form_control_error');
    }

    /**
     * form element on error class name
     *
     * @return string
     */
    protected function getHelpTextErrorClassName(): string
    {
        return $this->getClassName('help_text_error');
    }

    /**
     * button element class name
     *
     * @return string
     */
    protected function getButtonClass(): string
    {
        return $this->getClassName('button');
    }

    /**
     * wrapper div element class name for checkbox
     *
     * @param boolean $inline
     * @return string
     */
    protected function getCheckboxWrapperClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_checkbox_wrapper');
        }
        return $this->getClassName('checkbox_wrapper');
    }

    /**
     * checkbox class name
     *
     * @param boolean $inline
     * @return string
     */
    protected function getCheckboxInputClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_checkbox_input');
        }
        return $this->getClassName('checkbox_input');
    }

    /**
     * label element class name for checkbox
     *
     * @param boolean $inline
     * @return string
     */
    protected function getCheckboxLabelClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_checkbox_label');
        }
        return $this->getClassName('checkbox_label');
    }

    /**
     * wrapper div element class name for radio
     *
     * @param boolean $inline
     * @return string
     */
    protected function getRadioWrapperClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_radio_wrapper');
        }
        return $this->getClassName('radio_wrapper');
    }

    /**
     * radio class name
     *
     * @param boolean $inline
     * @return string
     */
    protected function getRadioInputClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_radio_input');
        }
        return $this->getClassName('radio_input');
    }

    /**
     * label element class name for radio
     *
     * @param boolean $inline
     * @return string
     */
    protected function getRadioLabelClassName(bool $inline = false): string
    {
        if ($inline) {
            return $this->getClassName('inline_radio_label');
        }
        return $this->getClassName('radio_label');
    }
}
