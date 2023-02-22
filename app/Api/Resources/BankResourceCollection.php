<?php

namespace App\Api\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($bank) use ($request) {
            return [
                'id' => $bank->id,
                'name' => $bank->name
            ];
        });

        return $data;
    }
}
