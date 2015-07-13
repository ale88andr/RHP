<?php

namespace Environment\Interfaces\Application;

interface Configuration
{
    public function get($item);

    public function set(array $item, $value);
}