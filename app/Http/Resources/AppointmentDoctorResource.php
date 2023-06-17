<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Appointment $this */
        return [
            'id' => $this->id,
            'doctor' => new PatientResource(User::query()->where('id', '=', $this->patient_id)->first()),
            'date' => $this->date,
            'content' => $this->content
        ];
    }
}
