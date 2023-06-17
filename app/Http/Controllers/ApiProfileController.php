<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Models\InformationDoctor;
use App\Models\InformationPatient;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class ApiProfileController extends Controller
{

    public function index(): DoctorResource|AnonymousResourceCollection
    {
        $profile = User::where('id', "=", auth()->id())->get();

        if (auth()->user()->is_doctor) {
            return new DoctorResource($profile);
        } else {
            return PatientResource::collection($profile);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'last_name' => 'nullable',
                'first_name' => 'nullable',
                'email' => 'email|nullable',
            ]);

            if ($validate->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validate->errors()
                ], 401);
            }

            auth()->user()->update([
                'last_name' => $request->get('last_name') ?? auth()->user()->last_name,
                'first_name' => $request->get('first_name') ?? auth()->user()->first_name,
                'email' => $request->get('email') ?? auth()->user()->email,
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

    public function updateInformation (Request $request): JsonResponse
    {
        try {

            if (auth()->user()->is_doctor == true) {
                InformationDoctor::query()
                    ->where('id_doctor', '=', auth()->id())
                    ->update([
                        'speciality' => $request->get('speciality') ?? auth()->user()->informationDoctor()->speciality,
                        'address' => $request->get('address') ?? auth()->user()->informationDoctor()->address,
                        'postal_code' => $request->get('postal_code') ?? auth()->user()->informationDoctor()->postal_code,
                        'city' => $request->get('city')  ?? auth()->user()->informationDoctor()->city,
                        'description' => $request->get('description') ?? auth()->user()->informationDoctor()->description,
                        'rates' => $request->get('rates') ?? auth()->user()->informationDoctor()->rates,
                    ]);
            } else {
               InformationPatient::query()
                   ->where('id_patient', '=', auth()->id())
                   ->update([
                       'phone' => $request->get('phone') ?? auth()->user()->informationPatient()->phone,
                       'birthday_date' => $request->get('birthday_date') ?? auth()->user()->informationPatient()->birthday_date,
                       'nationality' => $request->get('nationality') ?? auth()->user()->informationPatient()->nationality
                   ]);
            }

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

    public function delete()
    {
        try {
            $user =  auth()->user();
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete account successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
