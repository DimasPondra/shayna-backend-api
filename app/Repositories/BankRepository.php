<?php

namespace App\Repositories;

use App\Models\Bank;

class BankRepository
{
    private $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $banks = $this->model
            ->when(!empty($params['search']['name']), function ($query) use ($params) {
                return $query->where('name', 'LIKE', '%' . $params['search']['name'] . '%');
            });

        if (!empty($params['paginate'])) {
            return $banks->paginate($params['paginate']);
        }

        return $banks->get();
    }

    public function store(Bank $bank)
    {
        $bank->save();

        return $bank;
    }
}
