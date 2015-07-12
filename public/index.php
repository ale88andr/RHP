<?php

require_once '../config/defines.php';

require_once ROOT . DS . 'src' . DS . 'Environment' . DS .'initializer' . EXT;

use Environment\Core\App;

$app = new App;
try {
    require_once $app->layout();
}

catch(\Exception $e) {
    die($e->getMessage());
}