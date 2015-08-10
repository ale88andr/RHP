<?php

require_once '../config/defines.php';
require_once '../src/Environment/Autoloader.php';

Autoloader::registerAutoloader();

$app = new Environment\Core\App;

try {
    require_once $app->layout();
} catch(\Exception $e) {
    die($e->getMessage());
}