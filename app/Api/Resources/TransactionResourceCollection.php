<?php

namespace App\Api\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($transaction) use ($request) {
            return [
                'id' => $transaction->id,
                'uuid' => $transaction->uuid,
                'total' => 'Rp ' . $transaction->format_total,
                'status' => $transaction->status
            ];
        });

        return $data;
    }
}
