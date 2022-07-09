<?php

namespace App\Http\Controllers\API\V01;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method Post
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate Form Inputs
        $request->validate([
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'password' => ['required']
        ]);

        // Insert User Into Database
        resolve(UserRepository::class)->create($request);

        return response()->json([
            'message'=> 'User Created Successfully'
        ],201);
    }

    /**
     *
     * Login User
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        // Check User Credentials For Login
        if (Auth::attempt($request->only(['email','password']))){
            return response()->json(Auth::user(),200);
        }

        throw ValidationException::withMessages([
            'email'=> 'incorrect credentiols.'
        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(),200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            "message"=>"logout successfully"
        ],200);
    }


}
