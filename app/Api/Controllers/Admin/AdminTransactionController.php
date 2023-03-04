<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\TransactionUpdateRequest;
use App\Api\Resources\TransactionResource;
use App\Api\Resources\TransactionResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionRepository->get([
            'paginate' => $request->per_page
        ]);

        return new TransactionResourceCollection($transactions);
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        try {
            DB::beginTransaction();

            $data = $request->only(['status']);

            $this->transactionRepository->store($transaction->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Transaction successfully updated.'
        ], 201);
    }
}
