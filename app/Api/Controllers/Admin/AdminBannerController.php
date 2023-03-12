<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\BannerStoreRequest;
use App\Api\Resources\BannerResource;
use App\Api\Resources\BannerResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerRepository->get([
            'paginate' => $request->per_page
        ]);

        return new BannerResourceCollection($banners);
    }

    public function store(BannerStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'description', 'file_id']);

            $banner = new Banner();
            $this->bannerRepository->store($banner->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Banner successfully created.'
        ], 201);
    }

    public function show(Banner $banner)
    {
        return new BannerResource($banner);
    }

    public function destroy(Banner $banner)
    {
        try {
            DB::beginTransaction();

            if (Banner::count() == 1) {
                return response()->json([
                    'message' => 'Cannot be deleted, banners must be more than 1.'
                ], 400);
            }

            $banner->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Banner successfully deleted.'
        ], 201);
    }
}
