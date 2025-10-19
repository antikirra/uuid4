<?php

namespace Antikirra;

use InvalidArgumentException;

/**
 * @return string
 */
function uuid4()
{
    $data = \random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


/**
 * @param string $uuid4
 * @return bool
 */
function uuid4_validate($uuid4)
{
    if (!is_string($uuid4)) {
        throw new InvalidArgumentException('UUID must be a string, got ' . gettype($uuid4));
    }

    return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid4) === 1;
}
