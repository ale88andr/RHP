<?php

namespace Environment\Config;

use Environment\Helpers\Hash;

class Configuration
{
    protected $items = [];

    public function __construct($fromFile)
    {
        $this->items = include($fromFile);
    }

    public function get($item)
    {
        return Hash::get($this->items, $item);
    }

    public function set($item, $value)
    {
        Hash::set($this->items, $item, $value);
    }
}