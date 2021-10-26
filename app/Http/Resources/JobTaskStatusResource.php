<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobTaskStatusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status' => $this->getStatusName()
        ];
    }
}
