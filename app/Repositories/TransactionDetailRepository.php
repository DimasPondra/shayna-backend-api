<?php

namespace App\Repositories;

use App\Models\TransactionDetail;

class TransactionDetailRepository
{
    public function store(TransactionDetail $transactionDetail)
    {
        $transactionDetail->save();

        return $transactionDetail;
    }
}
