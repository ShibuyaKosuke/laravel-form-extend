# laravel-form-extend

Laravel 7+ form wrappers for Bootstrap and bulma.

## Support css framework

- [Bootstrap 3](https://getbootstrap.com/docs/3.4/)
- [Bootstrap 4](https://getbootstrap.com/docs/4.5/getting-started/introduction/)
- [Bulma](https://bulma.io/)

## Install 

```shell script
composer require shibuyakosuke/laravel-form-extend
```

## Config file

Publish config file.

```shell script
php artisan vendor:publish --tag=lara-form
```

## Set css framework name

Edit config/lara_form.php.

```
'default' => 'bootstrap4', // bootstrap3 or bulma
```

## Example

```
{{ LaraForm::horizontal() }}

{{ LaraForm::text('text', 'text') }}
{{ LaraForm::password('password', 'password') }}
{{ LaraForm::tel('tel', 'tel') }}
{{ LaraForm::email('email', 'email') }}
{{ LaraForm::date('date', 'date') }}
{{ LaraForm::datetime('datetime', 'datetime') }}
{{ LaraForm::datetimeLocal('datetime-local', 'datetime-local') }}
{{ LaraForm::url('url', 'url') }}
{{ LaraForm::search('search', 'search') }}

{{ LaraForm::number('number', 'number') }}
{{ LaraForm::time('time', 'time') }}
{{ LaraForm::file('file', 'file') }}
{{ LaraForm::range('range', 'range', 10, ['min' => 0, 'max' => 100, 'step' => 10]) }}
{{ LaraForm::select('select', 'select', [], null, ['placeholder' => '----']) }}
{{ LaraForm::textarea('textarea', 'textarea', null) }}

{{ LaraForm::checkboxes('checkboxes', 'checkboxes', [1 => 'choice1', 2 => 'choice2'], []) }}
{{ LaraForm::radios('radios', 'radios', [1 => 'choice1', 2 => 'choice2'], null) }}

{{ LaraForm::checkbox('check', 'check', 1) }}
{{ LaraForm::radio('radio', 'radio', 1) }}
{{ LaraForm::button('Button') }}

{{ LaraForm::submit() }}

{{ LaraForm::close() }}
```