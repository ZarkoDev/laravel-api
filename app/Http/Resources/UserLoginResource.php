<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'email' => $this->email,
            'token' => $this->token
        ];
    }
}
