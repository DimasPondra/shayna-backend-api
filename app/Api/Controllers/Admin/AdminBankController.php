<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\BankStoreRequest;
use App\Api\Requests\BankUpdateRequest;
use App\Api\Resources\BankResource;
use App\Api\Resources\BankResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Repositories\BankRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBankController extends Controller
{
    private $bankRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function index(Request $request)
    {
        $banks = $this->bankRepository->get([
            'search' => [
                'name' => $request->name
            ],
            'paginate' => $request->per_page
        ]);

        return new BankResourceCollection($banks);
    }

    public function store(BankStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['name']);

            $bank = new Bank();
            $this->bankRepository->store($bank->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank successfully created.'
        ], 201);
    }

    public function show(Bank $bank)
    {
        return new BankResource($bank);
    }

    public function update(BankUpdateRequest $request, Bank $bank)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['name']);

            $this->bankRepository->store($bank->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank successfully updated.'
        ], 201);
    }

    public function destroy(Bank $bank)
    {
        try {
            DB::beginTransaction();

            $bank->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Bank successfully deleted.'
        ], 201);
    }
}
