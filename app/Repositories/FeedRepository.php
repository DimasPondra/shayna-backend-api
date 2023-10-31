<?php

namespace App\Repositories;

use App\Models\Feed;

class FeedRepository
{
    private $model;

    public function __construct(Feed $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $feeds = $this->model
            ->when(!empty($params['limit']), function ($query) use ($params) {
                return $query->limit($params['limit']);
            });

        if (!empty($params['paginate'])) {
            return $feeds->paginate($params['paginate']);
        }

        return $feeds->get();
    }

    public function store(Feed $feed)
    {
        $feed->save();

        return $feed;
    }
}
