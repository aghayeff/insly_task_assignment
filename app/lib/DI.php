<?php
namespace App\Lib;

class DI
{
    private static $objects;

    public static function set($key, $value)
    {
        return self::$objects[$key] = $value;
    }

    public static function get($key)
    {
        return isset(self::$objects[$key]) ? self::$objects[$key] : null;
    }
}
