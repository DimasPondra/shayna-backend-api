<?php

namespace App\Api\Controllers\Admin;

use App\Api\Resources\UserResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->get([
            'search' => [
                'name' => $request->name,
                'role' => User::ROLE_USER
            ],
            'paginate' => $request->per_page
        ]);

        return new UserResourceCollection($users);
    }
}
