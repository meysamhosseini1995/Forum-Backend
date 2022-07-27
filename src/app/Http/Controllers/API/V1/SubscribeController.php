<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Http\Response;


class SubscribeController extends Controller
{

    public function __construct()
    {
        $this->middleware(["auth:sanctum"]);
    }

    public function subscribe(Thread $thread)
    {
        auth()->user()->subscribes()->create(['thread_id'=>$thread->id]);

        return response()->json([
            'message' => 'user subscribe successfully'
        ], Response::HTTP_OK);
    }

    public function unSubscribe(Thread $thread)
    {
        Subscribe::query()->where(['thread_id'=>$thread->id,'user_id'=>auth()->id()])->delete();

        return response()->json([
            'message' => 'user unSubscribe successfully'
        ], Response::HTTP_OK);
    }

}
