<?php

spl_autoload_register(function($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if(file_exists(ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName)){
            require_once ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName;
        } elseif (file_exists(ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $fileName)){
            require_once ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $fileName;
        }

    }
);