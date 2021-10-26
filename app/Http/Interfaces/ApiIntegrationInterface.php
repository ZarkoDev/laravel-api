<?php

namespace App\Http\Interfaces;

interface ApiIntegrationInterface
{
    public function isResponseFailed();
    public function getHttpStatusCode();
    public function getResponseBody();
}
