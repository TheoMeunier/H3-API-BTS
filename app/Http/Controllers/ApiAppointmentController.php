<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiAppointmentController extends Controller
{
    //Doctor
    //tout pour un medecin
    public function allDoctor(int $id)
    {
        $appointments = Appointment::query()
            ->with('user')
            ->where('id_doctor', '=', $id)
            ->firstOrFail();

        return AppointmentResource::collection($appointments);
    }

    //Patient
    //Prendre un rendez vous
    public function add(Request $request)
    {
        try {
            Appointment::create([
                'date' => $request->get('date'),
                'id_doctor' => $request->get('id_doctor'),
                'id_patient' => auth()->id()
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

    //rendez vous passé
    public function pastPatient(int $id)
    {
        $appointments = Appointment::query()
            ->with(['user'])
            ->where('id_patient', '=', $id)
            ->where('date', '<=', Carbon::now())
            ->firstOrFail();

        return AppointmentResource::collection($appointments);
    }

    //rendez vous avenir
    public function futurePatient(int $id)
    {
        $appointments = Appointment::query()
            ->where('id_patient', '=', $id)
            ->where('date', '>=', Carbon::now())
            ->firstOrFail();

        return AppointmentResource::collection($appointments);
    }
}
