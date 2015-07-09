<?php

namespace Environment\Helpers;

class Hash
{
    public static function add($array, $key, $value)
    {
        if(is_null(static::get($array, $key)))
        {
            static::set($array, $key, $value);
        }
    }

    public static function get($array, $key)
    {
        if(is_null($key))
        {
            return $array;
        }

        if (isset($array[$key]))
        {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment)
        {
            if (!is_array($array) || !array_key_exists($segment, $array)) {return null;}
            $array = $array[$segment];
        }

        return $array;
    }

    public static function set(&$array, $key, $value)
    {
        if(is_null($key))
        {
            return $value;
        }

        $array[$key] = $value;

        return $array;
    }
}