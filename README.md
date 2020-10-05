# laravel-form-extend

![CircleCI](https://img.shields.io/circleci/build/github/ShibuyaKosuke/laravel-form-extend/master)
![GitHub](https://img.shields.io/github/license/ShibuyaKosuke/laravel-form-extend)

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

## Supported 

### Elements

|  | Bootstrap 4 | Bootstrap 3 | Bulma |
|:----|:---:|:----:|:---:|
|input::text| OK | OK | OK |
|input::password| OK | OK | OK |
|input::email| OK | OK | OK |
|input::url| OK | OK | OK |
|input::search| OK | OK | OK |
|input::range| OK | OK | OK |
|input::hidden| OK | OK | OK |
|input::number| OK | OK | OK |
|input::tel| OK | OK | OK |
|input::date| OK | OK | OK |
|input::datetime| OK | OK | OK |
|input::datetimeLocal| OK | OK | OK |
|input::time| OK | OK | OK |
|input::week| OK | OK | OK |
|input::file| OK | OK | OK |
|input::color| OK | OK | OK |
|button:submit| OK | OK | OK |
|button:button| OK | OK | OK |
|select| OK | OK | OK |
|textarea| OK | OK | OK |
|checkbox| OK | OK | OK |
|checkboxes| OK | OK | OK |
|radio| OK | OK | OK |
|radios| OK | OK | OK |

### Addon

|  | Bootstrap 4 | Bootstrap 3 | Bulma |
|:----|:---:|:----:|:---:|
|text| OK | OK | OK |
|button| OK | OK | OK |
|icon| OK | OK | OK |

## Example

### Blade

```blade
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forms</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{ LaraForm::linkCss() }}

</head>
<body>
<div class="container">
    <h2>{{ LaraForm::name() }}</h2>

    {{ LaraForm::horizontal() }}

    {{ LaraForm::text('text', 'text', null) }}
    {{ LaraForm::password('password', 'password') }}
    {{ LaraForm::tel('tel', 'tel', null) }}
    {{ LaraForm::email('email', 'email', null) }}
    {{ LaraForm::date('date', 'date', null) }}
    {{ LaraForm::datetime('datetime', 'datetime', null) }}
    {{ LaraForm::datetimeLocal('datetime-local', 'datetime-local', null) }}
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
</div>
</body>
</html>
```

### Output

```html
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forms</title>
    <link rel="stylesheet" href="/css/app.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>bootstrap4</h2>

    <form method="POST" action="http://from.homestead.test" accept-charset="UTF-8" class="form-horizontal bootstrap4"><input name="_token" type="hidden" value="Bv2CBPTgs9XHrk9Xu9w01slNWFrgPqx7S4GbxVn1">

    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="text">text</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="text" type="text" id="text"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="password">password</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="password" type="password" value="" id="password"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="tel">tel</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="tel" type="tel" id="tel"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="email">email</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="email" type="email" id="email"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="date">date</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="date" type="date" id="date"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="datetime">datetime</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="datetime" type="datetime" id="datetime"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="datetime-local">datetime-local</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="datetime-local" type="datetime-local" id="datetime-local"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="url">url</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="url" type="url" id="url"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="search">search</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="search" type="search" id="search"></div></div>

    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="number">number</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="number" type="number" id="number"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="time">time</label></div><div class="col-sm-10 col-md-9"><input class="form-control" name="time" type="time" id="time"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="file">file</label></div><div class="col-sm-10 col-md-9"><input class="form-control-file" name="file" type="file" id="file"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="range">range</label></div><div class="col-sm-10 col-md-9"><input min="0" max="100" step="10" class="form-control" name="range" type="range" value="10" id="range"></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="select">select</label></div><div class="col-sm-10 col-md-9"><select class="form-control" id="select" name="select"><option selected="selected" value="">----</option></select></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><label for="textarea">textarea</label></div><div class="col-sm-10 col-md-9"><textarea class="form-control" name="textarea" cols="50" rows="10" id="textarea"></textarea></div></div>

    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><div class="col-sm-2 col-md-3 col-form-label">checkboxes</div></div><div class="col-sm-10 col-md-9"><div><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="checkboxes[]" type="checkbox" value="1"> choice1</label></div><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="checkboxes[]" type="checkbox" value="2"> choice2</label></div></div></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"><div class="col-sm-2 col-md-3 col-form-label">radios</div></div><div class="col-sm-10 col-md-9"><div><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="radios" type="radio" value="1"> choice1</label></div><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="radios" type="radio" value="2"> choice2</label></div></div></div></div>

    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"></div><div class="col-sm-10 col-md-9"><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="check" type="checkbox" value="1"> check</label></div></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"></div><div class="col-sm-10 col-md-9"><div class="form-check"><label class="form-check-label"><input class="form-check-input" name="radio" type="radio" value="1"> radio</label></div></div></div>

    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"></div><div class="col-sm-10 col-md-9"><button class="btn btn-primary" type="button">Button</button></div></div>
    <div class="form-group row"><div class="col-sm-2 col-md-3 col-form-label"></div><div class="col-sm-10 col-md-9"><input class="btn btn-primary" type="submit"></div></div>

    </form>
</div>
</body>
</html>
```

## ScreeShot

Screenshot when error. 

![Bootstrap4](https://raw.githubusercontent.com/ShibuyaKosuke/laravel-form-extend/master/screenshots/screeshot-bootstrap4.png "Bootstrap4")

## Addons

```blade
{{ LaraForm::email('email', 'email', null, ['prefix' => LaraForm::addonText('E-mail')]) }}

{{ LaraForm::email('email', 'email', null, ['suffix' => LaraForm::addonButton('submit')]) }}

{{ LaraForm::email('email', 'email', null, ['prefix' => LaraForm::addonIcon('fas fa-envelope')]) }}
```