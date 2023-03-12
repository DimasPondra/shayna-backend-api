<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($banner) use ($request) {
            return [
                'id' => $banner->id,
                'name' => $banner->name,
                'description' => $banner->description,

                'file' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'file'),
                    (new FileResource($banner->file))
                )
            ];
        });

        return $data;
    }
}
