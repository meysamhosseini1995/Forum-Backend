<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function userNotification()
    {
        return response()->json(
            auth()->user()->unreadNotifications(), Response::HTTP_OK
        );
    }
}
