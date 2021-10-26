<?php

namespace App\Http\Services;

use App\Http\Interfaces\ApiIntegrationInterface;

class BaseApiService implements ApiIntegrationInterface
{
    CONST ERROR_MESSAGE_DEFAULT = 'Missing error message';

    protected $response;
    protected $responseBody;

    public function isResponseFailed()
    {
        return $this->response->failed();
    }

    public function getHttpStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }
}
