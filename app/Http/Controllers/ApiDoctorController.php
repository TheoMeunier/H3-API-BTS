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
}
