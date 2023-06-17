<?php

namespace Database\Factories;

use App\Models\InformationDoctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InformationDoctor>
 */
class InformationDoctorFactory extends Factory
{

    protected $model = InformationDoctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'speciality' => $this->faker->randomElement(['Généraliste', 'Cardiologue', 'Radiologue', 'Dentiste', 'Kiné']),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'description' => $this->faker->text,
            'rates' => $this->faker->randomElement(['25', '50', '75', '100'])
        ];
    }
}
