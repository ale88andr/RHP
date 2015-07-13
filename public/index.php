<?php

require_once '../config/defines.php';

require_once ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Environment' . DIRECTORY_SEPARATOR .'initializer.php';

use Environment\Core\App;

$app = new App;
try {
    require_once $app->layout();
}

catch(\Exception $e) {
    die($e->getMessage());
}