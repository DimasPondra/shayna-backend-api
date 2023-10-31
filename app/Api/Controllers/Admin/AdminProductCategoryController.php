<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\ProductCategoryStoreRequest;
use App\Api\Requests\ProductCategoryUpdateRequest;
use App\Api\Resources\ProductCategoryResource;
use App\Api\Resources\ProductCategoryResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProductCategoryController extends Controller
{
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(Request $request)
    {
        $productCategories =  $this->productCategoryRepository->get([
            'search' => [
                'name' => $request->name
            ],
            'paginate' => $request->per_page
        ]);

        return new ProductCategoryResourceCollection($productCategories);
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->merge([
                'slug' => Str::slug($request->name)
            ]);

            $data = $request->only(['name', 'slug']);

            $productCategory = new ProductCategory();
            $this->productCategoryRepository->store($productCategory->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Product category successfully created.'
        ], 201);
    }

    public function show(ProductCategory $productCategory)
    {
        return new ProductCategoryResource($productCategory);
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        try {
            DB::beginTransaction();

            $request->merge([
                'slug' => Str::slug($request->name)
            ]);

            $data = $request->only(['name', 'slug']);

            $this->productCategoryRepository->store($productCategory->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Product category successfully updated.'
        ], 200);
    }

    public function destroy(ProductCategory $productCategory)
    {
        try {
            DB::beginTransaction();

            $productCategory->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Product category successfully deleted.'
        ], 200);
    }
}
