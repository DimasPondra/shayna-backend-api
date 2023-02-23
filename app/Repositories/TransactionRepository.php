<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    private $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $transactions = $this->model
            ->when(!empty($params['search']['user_id']), function ($query) use ($params) {
                return $query->where('user_id', $params['search']['user_id']);
            });

        if (!empty($params['paginate'])) {
            return $transactions->paginate($params['paginate']);
        }

        return $transactions->get();
    }

    public function store(Transaction $transaction)
    {
        $transaction->save();

        return $transaction;
    }
}
