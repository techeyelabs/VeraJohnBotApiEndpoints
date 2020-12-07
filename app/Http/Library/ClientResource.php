<?php

namespace App\Http\Library;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        //You can access model properties directly using $this
        return [
            'id' => Hashids::encode($this->id),
            "name" => $this->name,
            "password" => $this->password,
            "token" => $this->token
        ];
    }
}