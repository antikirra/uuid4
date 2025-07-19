<?php

namespace Antikirra;

use InvalidArgumentException;

/**
 * @return string
 */
function uuid4()
{
    $hex = bin2hex(\random_bytes(18));
    $hex[8] = $hex[13] = $hex[18] = $hex[23] = '-';
    $hex[14] = '4';

    return $hex;
}


/**
 * @param string $uuid4
 * @return bool
 */
function uuid4_validate($uuid4)
{
    if (!is_string($uuid4)) {
        throw new InvalidArgumentException('UUID must be a string, given: ' . gettype($uuid4));
    }

    if (strlen($uuid4) !== 36) {
        return false;
    }

    return (bool)preg_match('~^[a-f\d]{8}-[a-f\d]{4}-4[a-f\d]{3}-[a-f\d]{4}-[a-f\d]{12}$~', $uuid4);
}
