<?php

namespace App\Repositories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThreadRepository
{

    /**
     * All Thread list
     */
    public function all(): Collection
    {
        return Thread::all();
    }

    /**
     * Get All Available Threads list
     */
    public function getAllAvailableThreads()
    {
        return Thread::whereFlag(true)->latest()->get();
    }

    /**
     * Get All Available Threads list
     */
    public function getThreadBySlug($slug)
    {
        return Thread::whereSlug($slug)->whereFlag(true)->first();
    }


    /**
     * @param Request $request
     */
    public function store(Request $request): void
    {
        Thread::create([
            'title'      => $request->input("title"),
            'content'    => $request->input("content"),
            'channel_id' => $request->input("channel_id"),
            'user_id'    => Auth::id(),
            'slug'       => Str::slug($request->input("title")),
        ]);
    }

    /**
     * @param Request $request
     */
    public function update(Thread $thread, Request $request): void
    {
        if ($request->has('best_answer_id')) {
            $thread->update(['best_answer_id' => $request->input("best_answer_id")]);
        }
        else {
            $thread->update([
                'title'      => $request->input("title"),
                'content'    => $request->input("content"),
                'channel_id' => $request->input("channel_id"),
                'slug'       => Str::slug($request->input("title")),
            ]);
        }
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        Thread::destroy($id);
    }
}