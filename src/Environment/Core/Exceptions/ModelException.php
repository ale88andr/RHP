<?php

namespace \Environment\Core\Exceptions;

use Exception;

class ModelException extends Exception
{
    public function errorMessage() {
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile() .
                    ': <b>' . $this->getMessage() . '</b> <br>' ;
        return $errorMsg;
    }
}