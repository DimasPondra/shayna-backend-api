<?php

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository
{
    private $model;

    public function __construct(Banner $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $banners = $this->model
            ->when(!empty($params['limit']), function ($query) use ($params) {
                return $query->limit($params['limit']);
            });

        if (!empty($params['paginate'])) {
            return $banners->paginate($params['paginate']);
        }

        return $banners->get();
    }

    public function store(Banner $banner)
    {
        $banner->save();

        return $banner;
    }
}
