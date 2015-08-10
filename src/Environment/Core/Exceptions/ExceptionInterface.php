<?php

namespace Environment\Core\Exceptions;

interface ExceptionInterface
{
    public function __toString();

    public function setMessage();
}