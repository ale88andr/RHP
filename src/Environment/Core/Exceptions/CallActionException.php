<?php

namespace Environment\Core\Exceptions;

use \Exception;

class CallActionException extends Exception implements ExceptionInterface
{
    private $controller;
    private $action;
    private $only;
    protected $message;

    public function __construct($controller, $action, $only = [], $code = 0, Exception $previous = null)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->only = $only;
        $this->setMessage();

        parent::__construct($this->message, $code, $previous);
    }

    public function __toString()
    {
        return $this->getMessage() . '<br>In ' . $this->getFile() . ', on line: ' . $this->getLine();
    }

    public function setMessage()
    {
        $this->message = 'Controller \'' . $this->controller . '\' does\'t have permitted action \'' . $this->action . '\'';
        if(!empty($this->only)){
            $this->message .= '<br>Permitted actions are : ' . implode(', ', $this->only);
        }
    }
}