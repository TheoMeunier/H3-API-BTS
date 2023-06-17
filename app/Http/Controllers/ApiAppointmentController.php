<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentDoctorResource;
use App\Http\Resources\AppointmentPatientResource;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiAppointmentController extends Controller
{
    public function add(Request $request): ?JsonResponse
    {
        try {
            Appointment::create([
                'date' => $request->get('date'),
                'doctor_id' => $request->get('doctor_id'),
                'patient_id' => auth()->id()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'appointment create with successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function past(): AnonymousResourceCollection
    {
        $column = auth()->user()->is_doctor ? 'doctor_id' : 'patient_id';

        $appointments = Appointment::query()
            ->where($column, '=', auth()->id())
            ->where('date', '<', Carbon::now())
            ->get();

        if (auth()->user()->is_doctor) {
            return AppointmentDoctorResource::collection($appointments);
        } else {
            return AppointmentPatientResource::collection($appointments);
        }
    }

    public function futur(): AnonymousResourceCollection
    {
        $column = auth()->user()->is_doctor ? 'doctor_id' : 'patient_id';

        $appointments = Appointment::query()
            ->where($column, '=', auth()->id())
            ->where('date', '>', Carbon::now())
            ->get();

        if (auth()->user()->is_doctor) {
            return AppointmentDoctorResource::collection($appointments);
        } else {
            return AppointmentPatientResource::collection($appointments);
        }
    }
}
