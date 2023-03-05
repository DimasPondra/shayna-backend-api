<?php

namespace App\Api\Controllers\Client;

use App\Api\Resources\BankAccountResource;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;

class ClientBankAccountController extends Controller
{
    public function getActiveStatus()
    {
        $bankAccount = BankAccount::where('status', BankAccount::STATUS_ACTIVE)->first();

        return new BankAccountResource($bankAccount);
    }
}
