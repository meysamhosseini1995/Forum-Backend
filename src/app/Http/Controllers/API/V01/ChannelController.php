<?php

namespace App\Http\Controllers\API\V01;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function getAllChannelsList()
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
    public function createNewChannel(Request $request)
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
    public function updateChannel(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required'
        ]);

        // Update Channel To Database
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
            'message' => 'channel edited successfully'
        ], Response::HTTP_OK);
    }


    /**
     * Delete Channel
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id'=>['required']
        ]);

        // Delete Channel In DataBase
        resolve(ChannelRepository::class)->delete($request->id);

        return response()->json([
            "message"=>'channel deleted successfully'
        ],Response::HTTP_OK);
    }



}
