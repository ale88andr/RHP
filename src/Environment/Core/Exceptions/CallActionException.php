<?php

namespace Environment\Core\Exceptions;

use \Exception;

class CallActionException extends Exception
{
    private $controller;
    private $action;
    protected $message;

    public function __construct($controller, $action, $code = 0, Exception $previous = null)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->setMessage();

        parent::__construct($this->message, $code, $previous);
    }

    public function __toString()
    {
        return $this->getMessage() . '<br>In ' . $this->getFile() . ', on line: ' . $this->getLine();
    }

    private function setMessage()
    {
        $this->message = 'Controller \'' . $this->controller . '\' does\'t have action \'' . $this->action . '\'';
    }
}