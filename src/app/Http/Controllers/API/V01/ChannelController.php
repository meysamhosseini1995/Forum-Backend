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
        return response()->json(Channel::all(), 200);
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
     * Edit Channel
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function editChannel(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        // Update Channel To Database
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
            'message' => 'channel edited successfully'
        ], Response::HTTP_OK);
    }



}
