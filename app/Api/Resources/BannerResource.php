<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,

            'file' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'file'),
                (new FileResource($this->file))
            )
        ];
    }
}
