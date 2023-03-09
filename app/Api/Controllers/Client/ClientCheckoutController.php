<?php

namespace App\Api\Controllers\Client;

use App\Api\Resources\TransactionResource;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Repositories\CartRepository;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientCheckoutController extends Controller
{
    private $cartRepository, $transactionRepository,
        $transactionDetailRepository;

    public function __construct(
        CartRepository $cartRepository,
        TransactionRepository $transactionRepository,
        TransactionDetailRepository $transactionDetailRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transactionDetailRepository = $transactionDetailRepository;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            $carts = $this->cartRepository->get(['user_id' => $user->id]);
            $sub_total = $this->cartRepository->getTotal($user->id);

            if (count($carts) == 0) {
                return response()->json([
                    'message' => 'Your cart has no items.'
                ], 400);
            }

            $trxData = [
                'sub_total' => $sub_total,
                'total' => $sub_total,
                'user_id' => $user->id
            ];

            $transaction = new Transaction();
            $trx = $this->transactionRepository->store($transaction->fill($trxData));

            foreach ($carts as $cart) {
                $trxDetail = [
                    'price' => $cart->product->price,
                    'product_id' => $cart->product_id,
                    'transaction_id' => $trx->id
                ];

                $transactionDetail = new TransactionDetail();
                $this->transactionDetailRepository->store($transactionDetail->fill($trxDetail));

                $cart->delete();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Checkout successfully created.',
            'data' => [
                'transaction_id' => $trx->id,
                'transaction_uuid' => $trx->uuid
            ]
        ], 201);
    }
}
