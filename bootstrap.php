<?php

if (!function_exists('uuid4')) {
    function uuid4(): string
    {
        return \Antikirra\Uuid4\Uuid4::uuid4();
    }
}
