<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FeedResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($feed) use ($request) {
            return [
                'id' => $feed->id,
                'url' => $feed->url,

                'file' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'file'),
                    (new FileResource($feed->file))
                )
            ];
        });

        return $data;
    }
}
