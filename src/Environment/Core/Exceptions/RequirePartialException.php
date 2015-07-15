<?php

namespace Environment\Core\Exceptions;

use \Exception;
use \Environment\Helpers\Hash;

class RequirePartialException extends Exception
{
    private $partial;
    private $partial_path;
    protected $message;

    public function __construct(array $partial, $path, $code = 0, Exception $previous = null)
    {
        $this->partial = $partial;
        $this->partial_path = $path . 'views' . DIRECTORY_SEPARATOR . Hash::get($partial, 'dir');
        $this->message = $this->setMessage();

        parent::__construct($this->message, $code, $previous);
    }

    public function __toString()
    {
        return $this->getMessage() . '<br>In ' . $this->getFile() . ', on line: ' . $this->getLine();
    }

    public function setMessage() {
        $message =  'Partial "' . Hash::get($this->partial, 'file') . '" not found. Searched in: "' .
                    $this->partial_path . DIRECTORY_SEPARATOR . '"';

        return $message;
    }
}