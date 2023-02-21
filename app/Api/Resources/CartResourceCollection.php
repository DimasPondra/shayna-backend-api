<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($cart) use ($request) {
            return [
                'id' => $cart->id,

                'product' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'product'),
                    (new ProductResource($cart->product))
                ),

                'user' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'user'),
                    (new UserResource($cart->user))
                )
            ];
        });

        return $data;
    }
}
