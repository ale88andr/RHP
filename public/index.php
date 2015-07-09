<?php

use Environment\Routing\Route;
use Environment\Config\Configuration;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('PHP', '.php');

require_once ROOT.DS.'src'.DS.'Environment'.DS.'initializer'.PHP;
$cnf = require_once ROOT.DS.'config'.DS.'env'.PHP;
$env = new Configuration($cnf);

$router = new Route($_SERVER['REQUEST_URI']);

print_r($env->get('title'));