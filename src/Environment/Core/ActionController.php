<?php

namespace Environment\Core;

class ActionController
{

    public static function routingError($message = '', $code = '404', $status = 'Not Found')
    {
        header("HTTP/1.0" . $code . $status);
        header("HTTP/1.1" . $code . $status);
        header("Status:"  . $code . $status);
        include ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' .DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'output.html.php';
        die();
    }

}