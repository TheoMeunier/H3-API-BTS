<?php

namespace Database\Factories;

use App\Models\InformationDoctor;
use App\Models\InformationPatient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InformationPatient>
 */
class InformationPatientFactory extends Factory
{

    protected $model = InformationPatient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber,
            'nationality' => $this->faker->country,
            'birthday_date' => $this->faker->date
        ];
    }
}
