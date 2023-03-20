<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'last_name' => 'required',
                'first_name' => 'required',
                'email' => 'required',
                'phone' => 'required|min:9',
                'password' => 'required'
            ]);

            if ($validate->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validate->errors()
                ], 401);

            } else {
                User::create([
                    'last_name' => $request->get('last_name'),
                    'first_name' => $request->get('first_name'),
                    'phone' => $request->get('phone'),
                    'email' => $request->get('email'),
                    'is_doctor' => $request->get('is_doctor') ?? false,
                    'password' => Hash::make($request->get('password')),
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'User create successfully',
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);

            if ($validate->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validate->errors()
                ], 401);
            } else {
                if (!\Auth::attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email & password does not match with our record',
                    ], 401);
                }

                $user = User::where('email', $request->get('email'))->firstOrFail();

                return response()->json([
                    'status' => true,
                    'message' => 'User Login successfully',
                    'token' => $user->createToken("Api TOKEN")->plainTextToken
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {

    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }
}
