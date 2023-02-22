<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function store(Transaction $transaction)
    {
        $transaction->save();

        return $transaction;
    }
}
