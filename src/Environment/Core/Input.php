<?php

namespace Environment\Core;

class Input

{
    /**
     * Checks that users form is submitted.
     * Example: if(Input::isSubmit()) { # code here... }
     *
     * @param string $method   Form send method
     * @return bool
     */
    public static function isSubmit($method = 'post')
    {
        switch ($method) {
        case 'post':
            return (!empty($_POST)) ? true : false;
            break;

        case 'get':
            return (!empty($_GET)) ? true : false;
            break;

        default:
            return false;
            break;
        }
    }

    /**
     * Returns item from GET/POST array.
     * Example: Input::find($item)
     *
     * @param string $item   Item from GET/POST array
     * @return mixed
     */
    public static function find($item)
    {
        if(strpos($item, '.')) {
            $search_item = $_POST;
            foreach (explode('.', $item) as $value) {
                if(array_key_exists($value, $search_item)){
                    $search_item = $search_item[$value];
                }
            }

            return $search_item;
        }

        if (isset($_POST[$item])) {
            return static::filter($_POST[$item]);
        }
        elseif (isset($_GET[$item])) {
            return static::filter($_GET[$item]);
        }

        return '';
    }

    public static function filter($input)
    {
        $safe = is_array($input)
            ? array_map('static::filter', $input)
            : filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH);

        return $safe;
    }
}