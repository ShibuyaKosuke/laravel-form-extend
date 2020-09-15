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
