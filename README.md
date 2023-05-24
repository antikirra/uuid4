# Fast UUIDv4 implementation for PHP

## Install

```console
composer require antikirra/uuid4
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// only if the function has not been defined in the global scope
uuid4();

// if the function could not be defined globally
\Antikirra\uuid4();

// under the hood
\Antikirra\Uuid4\Uuid4::uuid4();
```

## Demo

```php
<?php
require __DIR__ . '/vendor/autoload.php';

echo uuid4(); // d9c30d61-eaaf-45c2-8ec1-3ce8de1ec96e
```
