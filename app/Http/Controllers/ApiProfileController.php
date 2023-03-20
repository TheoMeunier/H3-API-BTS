<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class ApiProfileController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $profile = User::where('id', "=", auth()->id())->get();

        return ProfileResource::collection($profile);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'last_name' => 'required',
                'first_name' => 'required',
                'email' => 'required',
                'phone' => 'required|min:9',
            ]);

            if ($validate->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validate->errors()
                ], 401);
            }

            auth()->user()->update([
                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User update successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function updatePassword(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'password' => 'required',
            ]);

            if ($validate->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validate->errors()
                ], 401);
            }

            auth()->user()->update([
                'password' => Hash::make($request->get('password')),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User password update successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
