<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionDetailResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($transactionDetail) use ($request) {
            return [
                'id' => $transactionDetail->id,
                'price' => 'Rp ' . $transactionDetail->format_price,
                'product_name' => $transactionDetail->product->name,
                'product_file_url' => $transactionDetail->product->file->show_file
            ];
        });

        return $data;
    }
}
