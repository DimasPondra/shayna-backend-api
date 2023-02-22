<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,

            'bank' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'bank'),
                (new BankResource($this->bank))
            )
        ];
    }
}
