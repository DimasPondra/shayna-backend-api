<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $users = $this->model
            ->when(!empty($params['search']['name']), function ($query) use ($params) {
                return $query->where('name', 'LIKE', '%' . $params['search']['name'] . '%');
            })
            ->when(!empty($params['search']['role']), function ($query) use ($params) {
                return $query->where('role', $params['search']['role']);
            });

        if (!empty($params['paginate'])) {
            return $users->paginate($params['paginate']);
        }

        return $users->get();
    }

    public function store(User $user)
    {
        $user->save();

        return $user;
    }
}
