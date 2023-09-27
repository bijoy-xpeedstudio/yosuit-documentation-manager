<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\ApiResponse;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => 1,
            'role' => $request->role??'user'
        ]);

        $token = $user->createToken('AppName')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('AppName')->accessToken;
            return response()->json([
                'user' => auth()->user(),
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function user()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function update_user(Request $request)
    {
        $request_time = date('Y-m-d H:i:s');
        if (isset($request->id)) {
            $user = User::find($request->id);
            if (is_null($user)) {
                return ApiResponse::response($user, [
                    'error' => [
                        'User not found'
                    ]
                ], 444, $request_time);
            }
        } else {
            $user = auth()->user();
        }

        $user_email_validation = '';
        if ($user->email != $request->email) {
            $user_email_validation = 'unique:users,email';
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|' . $user_email_validation,
            'role' => 'in:admin,user,editor'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        try {
            if ($user->save()) {
                return ApiResponse::response($user, [
                    'success' => [
                        'User has been updated'
                    ]
                ], 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
                ]
            ], 501, $request_time);
        }
    }
}
