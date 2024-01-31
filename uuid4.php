<?php

namespace Antikirra;

use InvalidArgumentException;

if (version_compare(PHP_VERSION, '7.0.0', '<') || !function_exists('random_bytes')) {
    /**
     * @param int $length
     * @return string
     */
    function random_bytes($length)
    {
        static $prev;

        $bytes = '';

        while (strlen($bytes) < $length) {
            list($a, $b) = tsids(2);
            $i = hash('md4', implode("#", [$prev, mt_rand(), $a, mt_rand(), $b]), true);
            $prev = $i;
            $bytes .= $i;
        }

        if (strlen($bytes) > $length) {
            $bytes = substr($bytes, 0, $length);
        }

        return $bytes;
    }
}

/**
 * @return string
 */
function uuid4()
{
    $hex = bin2hex(random_bytes(18));
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
        throw new InvalidArgumentException();
    }

    if (strlen($uuid4) !== 36) {
        return false;
    }

    return (bool)preg_match('~^[a-f\d]{8}-[a-f\d]{4}-4[a-f\d]{3}-[a-f\d]{4}-[a-f\d]{12}$~', $uuid4);
}
