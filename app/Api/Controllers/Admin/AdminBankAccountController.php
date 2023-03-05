<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\BankAccountStoreRequest;
use App\Api\Requests\BankAccountUpdateRequest;
use App\Api\Resources\BankAccountResource;
use App\Api\Resources\BankAccountResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Repositories\BankAccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBankAccountController extends Controller
{
    private $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function index(Request $request)
    {
        $bankAccounts = $this->bankAccountRepository->get([
            'search' => [
                'name' => $request->name
            ],
            'paginate' => $request->per_page
        ]);

        return new BankAccountResourceCollection($bankAccounts);
    }

    public function store(BankAccountStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'number', 'bank_id']);

            $bankAccount = new BankAccount();
            $this->bankAccountRepository->store($bankAccount->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank account successfully created.'
        ], 201);
    }

    public function show(BankAccount $bankAccount)
    {
        return new BankAccountResource($bankAccount);
    }

    public function update(BankAccountUpdateRequest $request, BankAccount $bankAccount)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'number', 'bank_id']);

            $this->bankAccountRepository->store($bankAccount->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank account successfully updated.'
        ], 201);
    }

    public function destroy(BankAccount $bankAccount)
    {
        try {
            DB::beginTransaction();

            $bankAccount->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank account successfully deleted.'
        ], 201);
    }

    public function changeStatus(BankAccount $bankAccount)
    {
        try {
            DB::beginTransaction();

            if ($bankAccount->status == BankAccount::STATUS_ACTIVE) {
                return response()->json([
                    'message' => 'Account bank is active cannot to change.'
                ], 400);
            }

            $data = BankAccount::where('status', BankAccount::STATUS_ACTIVE)->first();
            $this->bankAccountRepository->store($data->fill([
                'status' => BankAccount::STATUS_INACTIVE
            ]));

            $this->bankAccountRepository->store($bankAccount->fill([
                'status' => BankAccount::STATUS_ACTIVE
            ]));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank account successfully updated.'
        ], 201);
    }
}
