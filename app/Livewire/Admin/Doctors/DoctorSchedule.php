<?php

namespace App\Livewire\Admin\Doctors;

use App\Models\Doctor;
use App\Models\DoctorSchedule as ScheduleModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', [
    'title' => 'Horarios',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'href' => '/admin/dashboard'],
        ['name' => 'Doctores', 'href' => '/admin/doctors'],
        ['name' => 'Horarios'],
    ]
])]
class DoctorSchedule extends Component
{
    public Doctor $doctor;
    public $days = [
        1 => 'LUNES',
        2 => 'MARTES',
        3 => 'MIÉRCOLES',
        4 => 'JUEVES',
        5 => 'VIERNES',
        6 => 'SÁBADO',
    ];

    public $hours = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00'];
    public $selectedSlots = []; // [day][start_time] = true

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->loadSchedule();
    }

    public function loadSchedule()
    {
        $this->selectedSlots = [];
        $schedules = ScheduleModel::where('doctor_id', $this->doctor->id)->get();
        foreach ($schedules as $schedule) {
            $day = (int) $schedule->day_of_week;
            // Asegurarnos de que el formato coincida con el de la cuadrícula
            $time = date('H:i:s', strtotime($schedule->start_time));
            $this->selectedSlots[$day][$time] = true;
        }
    }

    public function toggleSlot($day, $time)
    {
        if (isset($this->selectedSlots[$day][$time])) {
            unset($this->selectedSlots[$day][$time]);
        } else {
            $this->selectedSlots[$day][$time] = true;
        }
    }

    public function toggleHourGroup($day, $baseHour)
    {
        $slots = $this->getSlotsForHour($baseHour);
        $allSelected = true;
        foreach ($slots as $slot) {
            if (!isset($this->selectedSlots[$day][$slot['start']])) {
                $allSelected = false;
                break;
            }
        }

        foreach ($slots as $slot) {
            if ($allSelected) {
                unset($this->selectedSlots[$day][$slot['start']]);
            } else {
                $this->selectedSlots[$day][$slot['start']] = true;
            }
        }
    }

    public function getSlotsForHour($hour)
    {
        $base = strtotime($hour);
        return [
            ['start' => date('H:i:s', $base), 'end' => date('H:i:s', $base + 900), 'label' => date('H:i', $base) . ' - ' . date('H:i', $base + 900)],
            ['start' => date('H:i:s', $base + 900), 'end' => date('H:i:s', $base + 1800), 'label' => date('H:i', $base + 900) . ' - ' . date('H:i', $base + 1800)],
            ['start' => date('H:i:s', $base + 1800), 'end' => date('H:i:s', $base + 2700), 'label' => date('H:i', $base + 1800) . ' - ' . date('H:i', $base + 2700)],
            ['start' => date('H:i:s', $base + 2700), 'end' => date('H:i:s', $base + 3600), 'label' => date('H:i', $base + 2700) . ' - ' . date('H:i', $base + 3600)],
        ];
    }

    public function save()
    {
        ScheduleModel::where('doctor_id', $this->doctor->id)->delete();

        foreach ($this->selectedSlots as $day => $times) {
            foreach ($times as $startTime => $value) {
                if ($value) {
                    ScheduleModel::create([
                        'doctor_id' => $this->doctor->id,
                        'day_of_week' => $day,
                        'start_time' => $startTime,
                        'end_time' => date('H:i:s', strtotime($startTime) + 900),
                    ]);
                }
            }
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Horario guardado',
            'text' => 'La disponibilidad del doctor se ha actualizado correctamente.',
            'timer' => 3000,
            'showConfirmButton' => false,
            'toast' => true,
            'position' => 'top-end'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.doctors.doctor-schedule');
    }
}
