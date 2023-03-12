<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository
{
    private $model;

    public function __construct(BankAccount $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $bankAccounts = $this->model
            ->when(!empty($params['search']['name']), function ($query) use ($params) {
                return $query->where('name', 'LIKE', '%' . $params['search']['name'] . '%');
            });

        if (!empty($params['paginate'])) {
            return $bankAccounts->paginate($params['paginate']);
        }

        return $bankAccounts->get();
    }

    public function store(BankAccount $bankAccount)
    {
        $bankAccount->save();

        return $bankAccount;
    }
}
