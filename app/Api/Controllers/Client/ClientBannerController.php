<?php

namespace App\Api\Controllers\Client;

use App\Api\Resources\BannerResourceCollection;
use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

class ClientBannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerRepository->get([
            'limit' => $request->limit
        ]);

        return new BannerResourceCollection($banners);
    }
}
