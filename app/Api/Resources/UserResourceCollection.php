<?php

namespace App\Api\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($user) use ($request) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'address' => $user->address
            ];
        });

        return $data;
    }
}
