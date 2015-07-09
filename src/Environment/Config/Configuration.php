<?php

namespace Environment\Config;

use Environment\Helpers\Hash;

class Configuration
{
    protected $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
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