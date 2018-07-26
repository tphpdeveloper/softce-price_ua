# Work with module slider

**1.**
```php
//write to composer.json
"require": {
    ...
    "softce/price_ua" : "dev-master"
}

"autoload": {
    ... ,

    "psr-4": {
        ... ,

        "Softce\\Priceua\\" : "vendor/softce/price_ua/src"
    }
}
```


**2.**
```php
//in console write

composer update softce/price_ua
```


**3.**
```php
//in service provider config/app

'providers' => [
    ... ,
    Softce\Priceua\Providers\PriceuaServiceProvider::class,
]


// in console 
php artisan config:cache
```


**4.**
```php
//for show page price ua, in code add next row

{{ route('admin.priceua.index') }}

```

# For delete module

```php
//delete next row

1.
//in app.php
Softce\Priceua\Providers\PriceuaServiceProvider::class,

2.
//in composer.json
"Softce\\Priceua\\": "vendor/softce/price_ua/src"

3.
//in console
composer remove softce/price_ua

4.
// delete -> bootstrap/config/cache.php

5.
//in console
php artisan config:cache

6.
//delete row in admin_menus table -> where name 'Price UA'
```

