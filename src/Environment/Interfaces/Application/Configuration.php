<?php

namespace Environment\Interfaces\Application;

interface Configuration
{
    public function initializeAppEnvironment();

    public function get($item);

    public function set($item, $value);
}