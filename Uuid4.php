<?php

declare(strict_types=1);

namespace Antikirra\Uuid4;

final class Uuid4
{
    public static function uuid4(): string
    {
        $hex = bin2hex(random_bytes(18));
        $hex[8] = $hex[13] = $hex[18] = $hex[23] = '-';
        $hex[14] = '4';

        return $hex;
    }
}
