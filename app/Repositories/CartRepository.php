<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    private $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $carts = $this->model
            ->when(!empty($params['user_id']), function ($query) use ($params) {
                return $query->where('user_id', $params['user_id']);
            });

        return $carts->get();
    }

    public function store(Cart $cart)
    {
        $cart->save();

        return $cart;
    }
}
