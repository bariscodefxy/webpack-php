## webpack-php
A loader that loads automatically your javascript files that compiled with webpack.

## Example Usage
```php
<?php

require_once "./vendor/autoload.php";

$webpack = new \bariscodefx\WebpackPHP\WebpackPHP("testdir/");
var_dump($webpack->asset('index.*\.js'));
var_dump($webpack->asset('main\.bundle.*\.js'));
```
Output:
```
string(63) "<script type="text/javascript" src="testdir/index.bundle.2.js">"
string(67) "<script type="text/javascript" src="testdir/main.bundle.312453.js">"
```

You can use this on your view templates.
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Foobar</title>
        <?= $webpack->asset('something\.bundle\.*\.js') ?>
...
```

Using styles:
```php
<!DOCTYPE html>
<html>
    <head>
        <title>Foobar</title>
        <?= $webpack->asset('something\.bundle\.*\.css', 'style') ?>
```