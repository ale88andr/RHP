<?php

namespace Environment\Interfaces\Application;

interface Foundation
{
    public function version();

    public function basePath();

    public function configPath();
}