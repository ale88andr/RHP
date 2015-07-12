<?php
define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', dirname(dirname(__FILE__)));
define ('ROOT_APP', ROOT . DS . 'app' . DS);
define ('EXT', '.php');
define ('EXT_VIEW', '.html.php');
define ('ROOT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/');
define ('DEVELOPMENT_ENV', true);
