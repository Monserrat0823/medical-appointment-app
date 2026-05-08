<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Doctor si no existe
        $doctorUser = \App\Models\User::firstOrCreate(
            ['email' => 'doctor@healthify.com'],
            [
                'name' => 'Dr. Luis Torres',
                'password' => bcrypt('password'),
                'id_number' => 'DOC001',
                'phone' => '123456789',
                'address' => 'Clínica Healthify',
            ]
        );

        \App\Models\Doctor::updateOrCreate(
            ['user_id' => $doctorUser->id],
            ['specialty' => 'Endocrinología']
        );

        // Crear Paciente si no existe
        $patientUser = \App\Models\User::firstOrCreate(
            ['email' => 'paciente@healthify.com'],
            [
                'name' => 'Isabel Ruiz',
                'password' => bcrypt('password'),
                'id_number' => 'PAC001',
                'phone' => '987654321',
                'address' => 'Calle Falsa 123',
            ]
        );

        \App\Models\Patient::updateOrCreate(
            ['user_id' => $patientUser->id],
            ['allergies' => 'Ninguna']
        );

        // Crear más pacientes y citas para "metele datos"
        $doctors = \App\Models\Doctor::all();
        $patients = \App\Models\Patient::all();

        for ($i = 1; $i <= 15; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();
            $date = now()->addDays(rand(-5, 10));
            $hour = rand(9, 17);
            
            \App\Models\Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'date' => $date->format('Y-m-d'),
                'start_time' => sprintf('%02d:00', $hour),
                'end_time' => sprintf('%02d:30', $hour),
                'duration' => 30,
                'reason' => 'Consulta de seguimiento ' . $i,
                'status' => rand(1, 3), // 1: Programada, 2: Completada, 3: Cancelada
                'diagnosis' => $i % 3 == 0 ? 'Diagnóstico preventivo' : null,
                'treatment' => $i % 3 == 0 ? 'Tratamiento básico' : null,
            ]);
        }
    }
}
