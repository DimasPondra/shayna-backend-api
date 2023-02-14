<?php

namespace App\Api\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FileResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($file) use ($request) {

                return [
                    'id' => $file->id,
                    'url' => $file->show_file
                ];
            })
        ];
    }
}
