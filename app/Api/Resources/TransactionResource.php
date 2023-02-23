<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'sub_total' => 'Rp ' . $this->format_sub_total,
            'total' => 'Rp ' . $this->format_total,
            'status' => $this->status,

            'user' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'user'),
                (new UserResource($this->user))
            ),

            'transaction_details' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'transaction_details'),
                (new TransactionDetailResourceCollection($this->transactionDetails))
            )
        ];
    }
}
