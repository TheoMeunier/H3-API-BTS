<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\InformationDoctor;
use App\Models\InformationPatient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //On crée les médecins
        User::factory(100)
            ->has(
                InformationDoctor::factory()->count(1)
            )
            ->create(['is_doctor' => true]);

        //On crée les patients
        User::factory(100)
            ->has(
                InformationPatient::factory()->count(1)
            )
            ->has(
                Appointment::factory()
                    ->count(10)
                    ->state(fn(array $attributes) => ['doctor_id' => random_int(1, 100)]), 'appointmentsPatient'
            )
            ->create();

        //On crée mon utilisateur
        User::factory()
            ->has(
                InformationPatient::factory(1)
            )
            ->has(
                Appointment::factory()
                    ->count(10)
                    ->state(fn(array $attributes) => ['doctor_id' => random_int(1, 100)]), 'appointmentsPatient'
            )
            ->create([
                'first_name' => 'Théo',
                'last_name' => 'Meunier',
                'email' => 'contact@theomeunier.fr',
                'email_verified_at' => now(),
                'password' => Hash::make('theotheo'),
            ]);
    }
}
