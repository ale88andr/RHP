<?php

namespace Environment\Core\Exceptions;

use \Exception;

class RequireModelException extends Exception
{
    private $model;
    private $model_path;
    protected $message;

    public function __construct($model, $path, $code = 0, Exception $previous = null)
    {
        $this->model = $model;
        $this->model_path = $path;
        $this->message = $this->setMessage();

        parent::__construct($this->message, $code, $previous);
    }

    public function __toString()
    {
        return $this->getMessage() . '<br>In ' . $this->getFile() . ', on line: ' . $this->getLine();
    }

    public function setMessage() {
        $message =  'Model class or file "' . $this->model . '" not found. Searched in: "' .
                    $this->model_path . 'models' . DIRECTORY_SEPARATOR . '"';

        return $message;
    }
}