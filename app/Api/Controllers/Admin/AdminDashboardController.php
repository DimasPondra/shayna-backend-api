<?php

namespace App\Api\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->count();
        $products = Product::count();
        $pending_transactions = Transaction::where('status', 'pending')->count();
        $success_transactions = Transaction::where('status', 'success')->count();

        $data = [
            'data' => [
                'user' => $users,
                'product' => $products,
                'pending_transaction' => $pending_transactions,
                'success_transaction' => $success_transactions
            ]
        ];

        return response()->json($data);
    }
}
