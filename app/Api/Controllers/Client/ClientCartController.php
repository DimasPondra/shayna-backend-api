<?php

namespace App\Api\Controllers\Client;

use App\Api\Requests\CartStoreRequest;
use App\Api\Resources\CartResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientCartController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index(Request $request)
    {
        $carts = $this->cartRepository->get();

        return new CartResourceCollection($carts);
    }

    public function store(CartStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->merge([
                'user_id' => auth()->id()
            ]);

            $data = $request->only(['product_id', 'user_id']);

            $cart = new Cart();
            $this->cartRepository->store($cart->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Cart successfully created.'
        ], 201);
    }
}
