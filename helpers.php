<?php


if (!function_exists('now')) {
    function now()
    {
        return new Carbon\CarbonImmutable();
    }
}

if (!function_exists('today')) {
    function today()
    {
        return now()->today();
    }
}

if (!function_exists('dd')) {
    function dd($value)
    {
        var_dump($value);
        die;
    }
}
