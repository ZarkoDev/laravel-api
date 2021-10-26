<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    
    public function render($request)
    {
        return response(['message' => $this->getMessage()], $this->getCode());
    }
}