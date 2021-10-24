<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return $request;
    }

    public function withResponse($request, $response)
    {
        $response->header('Content-type', 'application/json');
    }
}
