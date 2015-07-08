<?php

namespace Environment\Config;

class Configuration
{
    protected static $items = [];

    public static function get($item, $defaultValue = null)
    {
        return isset(self::$items[$item]) ? self::$items[$item] : $defaultValue;
    }

    public static function  set($item, $value)
    {
        self::$items[$item] = $value;
    }
}