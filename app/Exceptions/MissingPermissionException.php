<?php

namespace App\Exceptions;

class MissingPermissionException extends BaseException
{
    
    public function render($request)
    {
        return response(['message' => 'Missing permissions'], 400);
    }
}