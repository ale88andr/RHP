<?php

namespace Environment\Core\Exceptions;

use \Exception;
use \Environment\Helpers\Hash;
use \Environment\Helpers\String;

class RequireFileException extends Exception implements ExceptionInterface
{
    private $dataSet;
    private $path;
    private $type;
    protected $message;

    public function __construct($type, $file, $path, $code = 0, Exception $previous = null)
    {
        $this->dataSet = $file;
        $this->path = rtrim($path, DIRECTORY_SEPARATOR);
        $this->type = $type;
        $this->message = $this->setMessage();

        parent::__construct($this->message, $code, $previous);
    }

    public function __toString()
    {
        return $this->getMessage() . '<br>In ' . $this->getFile() . ', on line: ' . $this->getLine();
    }

    public function setMessage() {
        $message =  String::titlize($this->type) . ' "' . $this->dataSet . '" not found. Searched in: "' .
                    $this->path . DIRECTORY_SEPARATOR . '"';

        return $message;
    }
}