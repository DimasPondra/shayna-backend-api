<?php

namespace App\Api\Controllers\Client;

use App\Api\Resources\TransactionResource;
use App\Api\Resources\TransactionResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class ClientTransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionRepository->get([
            'search' => [
                'user_id' => auth()->id()
            ],
            'paginate' => $request->per_page
        ]);

        return new TransactionResourceCollection($transactions);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return new TransactionResource($transaction);
    }
}
