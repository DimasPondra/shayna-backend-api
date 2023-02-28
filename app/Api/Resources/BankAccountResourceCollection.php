<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankAccountResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($bankAccount) use ($request) {
            return [
                'id' => $bankAccount->id,
                'name' => $bankAccount->name,
                'number' => $bankAccount->number,
                'status' => $bankAccount->status,

                'bank' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'bank'),
                    (new BankResource($bankAccount->bank))
                )
            ];
        });

        return $data;
    }
}
