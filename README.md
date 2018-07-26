# Work with module prom_ua

**1.**
```php
//write to composer.json
"require": {
    ...
    "softce/prom_ua" : "dev-master"
}

"autoload": {
    ... ,

    "psr-4": {
        ... ,

        "Softce\\Promua\\" : "vendor/softce/prom_ua/src"
    }
}
```


**2.**
```php
//in console write

composer update softce/prom_ua
```


**3.**
```php
//in service provider config/app

'providers' => [
    ... ,
    Softce\Promua\Providers\PromuaServiceProvider::class,
]


// in console 
php artisan config:cache
```


**4.**
```php
//for show page price ua, in code add next row

{{ route('admin.promua.index') }}

```

# For delete module

```php
//delete next row

1.
//in app.php
Softce\Promua\Providers\PromuaServiceProvider::class,

2.
//in composer.json
"Softce\\Promua\\": "vendor/softce/prom_ua/src"

3.
//in console
composer remove softce/prom_ua

4.
// delete -> bootstrap/config/cache.php

5.
//in console
php artisan config:cache

6.
//delete row in admin_menus table -> where name 'Prom UA'
```

