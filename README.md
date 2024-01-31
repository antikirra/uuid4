# Fast UUIDv4 implementation for PHP

## Install

```console
composer require antikirra/uuid4:^2.0
```

## Basic usage

```php
<?php

use function Antikirra\uuid4;
use function Antikirra\uuid4_validate;

require __DIR__ . '/vendor/autoload.php';

uuid4(); // 19f16271-84eb-449c-d22b-0bbf7fcc1f63
uuid4_validate('74331057-8c1a-40f0-1e6f-a3073c3f56fc'); // true
```
