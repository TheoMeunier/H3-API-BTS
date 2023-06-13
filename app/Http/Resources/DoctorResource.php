<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $this */
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'speciality' => $this->informationDoctor->speciality ?? null,
            'address' => $this->informationDoctor->address ?? null,
            'postal_code' => $this->informationDoctor->postal_code ?? null,
            'city' => $this->informationDoctor->city ?? null,
            'description' => $this->informationDoctor->description ?? null,
            'rates' => $this->informationDoctor->rates ?? null,
        ];
    }
}
