<?php

declare(strict_types=1);

namespace Antikirra;

if (!function_exists('Antikirra\uuid4')) {
    function uuid4(): string
    {
        return \Antikirra\Uuid4\Uuid4::uuid4();
    }
}
