<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:thread management", "auth:sanctum"])->except(['index', 'show']);
    }


    /**
     * Get All Available Thread
     * @return JsonResponse
     */
    public function index()
    {
        $result = resolve(ThreadRepository::class)->getAllAvailableThreads();
        return response()->json($result, Response::HTTP_OK);
    }


    /**
     * Get One Thread From Slug
     *
     * @param $slug
     *
     * @return JsonResponse
     */
    public function show($slug)
    {
        $result = resolve(ThreadRepository::class)->getThreadBySlug($slug);
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Create New Thread
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'content'    => 'required',
            'channel_id' => 'required',
        ]);

        // Insert Channel To Database
        resolve(ThreadRepository::class)->store($request);

        return response()->json([
            'message' => 'thread created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update Thread
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Thread $thread, Request $request)
    {
        if ($request->has('best_answer_id')) {
            $request->validate([
                'best_answer_id' => 'required',
            ]);
        }
        else {
            $request->validate([
                'title'      => 'required',
                'content'    => 'required',
                'channel_id' => 'required',
            ]);
        }

        // Update Channel To Database
        resolve(ThreadRepository::class)->update($thread, $request);

        return response()->json([
            'message' => 'thread update successfully'
        ], Response::HTTP_OK);
    }


    /**
     * Delete Thread
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        // Delete Channel In DataBase
        resolve(ThreadRepository::class)->delete($id);

        return response()->json([
            "message" => 'thread deleted successfully'
        ], Response::HTTP_OK);
    }


}
