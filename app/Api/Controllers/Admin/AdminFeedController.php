<?php

namespace App\Api\Controllers\Admin;

use App\Api\Requests\FeedStoreRequest;
use App\Api\Resources\FeedResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Repositories\FeedRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFeedController extends Controller
{
    private $feedRepository;

    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function index(Request $request)
    {
        $feeds = $this->feedRepository->get([
            'paginate' => $request->per_page
        ]);

        return new FeedResourceCollection($feeds);
    }

    public function store(FeedStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['url', 'file_id']);

            $feed = new Feed();
            $this->feedRepository->store($feed->fill($data));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Feed successfully created.'
        ], 201);
    }

    public function destroy(Feed $feed)
    {
        try {
            DB::beginTransaction();

            $feed->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong, ' . $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Feed successfully deleted.'
        ], 200);
    }
}
