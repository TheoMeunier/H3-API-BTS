<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiDoctorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $doctors = User::where('is_doctor', true)->get();

        return DoctorResource::collection($doctors);
    }

    public function show(int $id)
    {
        try {
            $doctor = User::query()
                ->where('id', $id)
                ->firstOrFail();

            return new DoctorResource($doctor);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
