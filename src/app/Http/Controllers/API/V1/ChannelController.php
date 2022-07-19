<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChannelController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:channel management","auth:sanctum"])->except(['index']);
    }


    public function index()
    {
        $result = resolve(ChannelRepository::class)->all();
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Create New Channel
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Insert Channel To Database
        resolve(ChannelRepository::class)->create($request);

        return response()->json([
            'message' => 'channel created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Update Channel To Database
        resolve(ChannelRepository::class)->update($id, $request);

        return response()->json([
            'message' => 'channel edited successfully'
        ], Response::HTTP_OK);
    }


    /**
     * Delete Channel
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        // Delete Channel In DataBase
        resolve(ChannelRepository::class)->delete($id);

        return response()->json([
            "message" => 'channel deleted successfully'
        ], Response::HTTP_OK);
    }


}
