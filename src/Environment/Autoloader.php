<?php

class Autoloader
{

    public static function autoload($className)
    {
        $baseDir = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . DIRECTORY_SEPARATOR;
        $className = ltrim($className, '\\');
        $fileName  = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if(file_exists($baseDir . 'src' . DIRECTORY_SEPARATOR . $fileName)){
            require_once $baseDir . 'src' . DIRECTORY_SEPARATOR . $fileName;
        } elseif (file_exists($baseDir . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $fileName)){
            require_once $baseDir . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $fileName;
        }
    }

    public static function registerAutoloader()
    {
        spl_autoload_register(__NAMESPACE__ . "\\Autoloader::autoload");
    }
}