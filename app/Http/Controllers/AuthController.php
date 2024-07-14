<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'response' => $validateUser->errors()
                    ],
                    401
                );
            }

            $createUser = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]
            );

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Create user successfully.',
                    'response' => $createUser
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Create user Failed.',
                    'response' => $th->getMessage()
                ],
                500
            );
        }
    }

    public function Login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'response' => $validateUser->errors()
                    ],
                    401
                );
            }
            $auth = Auth::attempt($request->only(['email', 'password']));
            if (!$auth) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Email or Password invalid.!',
                    ],
                    401
                );
            }

            $user = User::find(Auth::id());
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Logged In user successfully.',
                    'response' => Auth::user(),
                    'token' =>  $user->createToken('API')->plainTextToken
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Logged In user Failed.',
                    'response' => $th->getMessage()
                ],
                500
            );
        }
    }

    public function Logout()
    {
        $TokenDelete = Auth::user()->tokens()->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'Logged out successfully.',
                'response' => auth()->user(),
            ],
            200
        );
    }
    public function UserProfile()
    {
        try {
            $user = auth()->user();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Profile successfully.',
                    'response' => $user,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Create user successfully.',
                    'response' => $th->getMessage()
                ],
                500
            );
        }
    }
}
