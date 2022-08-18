# php-core

Minimalist MVC framework for websites.

## Instalation

```console
composer require acffdev/php-core
```

## Usage

create an index.php file with the following code at the root of your public directory

```php

// composer autoload
require_once __DIR__.'/vendor/autoload.php';

// namespace
use Acffdev\PhpCore\App as App;

// initializes
try { 
	App::run();
} catch(Exception $e) { 
	echo $e->getMessage(); 
}

```

