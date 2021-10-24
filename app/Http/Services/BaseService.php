<?php

namespace App\Http\Services;

use App\Http\Traits\ErrorTrait;

abstract class BaseService
{
    use ErrorTrait;

    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
}
