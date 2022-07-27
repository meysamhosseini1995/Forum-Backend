<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use App\Repositories\AnswerRepository;
use App\Repositories\SubscribeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use function Spatie\LaravelIgnition\Recorders\JobRecorder\resolveCommandProperties;


class AnswerController extends Controller
{
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->middleware(["auth:sanctum"])->except(['index']);
    }


    /**
     * Get All Available Answer
     * @return JsonResponse
     */
    public function index()
    {
        $result = $this->answerRepository->getAllAnswers();
        return response()->json($result, Response::HTTP_OK);
    }


    /**
     * Create New Answer
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'content'   => 'required',
            'thread_id' => 'required',
        ]);

        //Insert Answer To Database
        resolve(AnswerRepository::class)->store($request);

        // Get List Of User Id Which Subscribed To A Thread Id
        $notifiable_user_id = resolve(SubscribeRepository::class)->getNotifiableUsers();

        // Get Users Instance From Id
        $notifiable_user = resolve(UserRepository::class)->find($notifiable_user_id);

        // Send NewReplySubmitted Notification To Subscribed User
        Notification::send($notifiable_user, new NewReplySubmitted(Thread::find($request->thread_id)));

        return response()->json([
            'message' => 'answer created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update Answer
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Answer $answer, Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);


        if (Gate::forUser(Auth::user())->allows("user-answer",$answer)){
            // Update Answer To Database
            resolve(AnswerRepository::class)->update($answer, $request);

            return response()->json([
                'message' => 'answer update successfully'
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
                "message"=> "access denied"
            ],Response::HTTP_FORBIDDEN);
        }
    }


    /**
     * Delete Answer
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Answer $answer)
    {
        //Delete Answer In DataBase
        if (Gate::forUser(Auth::user())->allows("user-answer", $answer)) {
            resolve(AnswerRepository::class)->delete($answer->id);

            return response()->json([
                "message" => 'answer deleted successfully'
            ], Response::HTTP_OK);
        }
        else {
            return response()->json([
                "message" => "access denied"
            ], Response::HTTP_FORBIDDEN);
        }
    }


}
