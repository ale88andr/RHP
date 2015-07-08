<?php

use Environment\Routing\Route;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('PHP', '.php');

require_once ROOT.DS.'src'.DS.'Environment'.DS.'initializer'.PHP;
require_once ROOT.DS.'config'.DS.'env'.PHP;

$router = new Route($_SERVER['REQUEST_URI']);