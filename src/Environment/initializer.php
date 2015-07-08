<?php

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DS, $namespace) . DS;
    }
    $fileName .= str_replace('_', DS, $className) . PHP;

    require ROOT.DS.'src'.DS.$fileName;
}

spl_autoload_register('autoload');