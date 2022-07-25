<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerRepository
{

    /**
     * Get All Available Answers list
     */
    public function getAllAnswers()
    {
        return Answer::query()->latest()->get();
    }


    /**
     * @param Request $request
     */
    public function store(Request $request): void
    {
        Thread::find($request->input("thread_id"))->answers()->create([
            'content' => $request->input("content"),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * @param Request $request
     */
    public function update(Answer $answer, Request $request): void
    {
        $answer->update([
            'content'   => $request->input("content"),
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        Answer::destroy($id);
    }
}