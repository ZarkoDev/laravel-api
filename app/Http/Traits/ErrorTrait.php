<?php

namespace App\Http\Traits;

trait ErrorTrait
{
    private $errors = [];
    private $statusCode;

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function setError(string $message, int $statusCode)
    {
        $this->errors[] = $message;
        $this->statusCode = $statusCode;
    }

    public function getErrors()
    {
        return ['errors' => $this->errors];
    }

    public function getErrorsToString()
    {
        return implode(';', $this->errors);
    }

    public function getErrorResponse()
    {
        return response()->json($this->getErrors(), $this->getStatusCode());
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
