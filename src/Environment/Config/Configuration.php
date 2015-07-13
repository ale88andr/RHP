<?php

namespace Environment\Config;

use Environment\Helpers\Hash;
use \Environment\Interfaces\Application\Configuration as ConfigurationInterface;

class Configuration implements ConfigurationInterface
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

    public function set(array $item, $value)
    {
        Hash::set($this->items, $item, $value);
    }
}