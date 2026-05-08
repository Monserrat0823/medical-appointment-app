<?php

namespace App\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', [
    'title' => 'Nueva Cita',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'href' => '/admin/dashboard'],
        ['name' => 'Citas', 'href' => '/admin/appointments'],
        ['name' => 'Nueva Cita'],
    ]
])]
class AppointmentCreate extends Component
{
    // Form & Search fields
    public $date;
    public $time_range;
    public $specialty;
    public $doctor_id;
    public $patient_id;
    public $start_time;
    public $end_time;
    public $reason;
    public $duration = 30;

    // View control
    public $showResults = false;

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function updatedStartTime()
    {
        $this->calculateDuration();
    }

    public function updatedEndTime()
    {
        $this->calculateDuration();
    }

    public function calculateDuration()
    {
        if ($this->start_time && $this->end_time) {
            $start = strtotime($this->start_time);
            $end = strtotime($this->end_time);
            $this->duration = ($end - $start) / 60;
            if ($this->duration < 0) $this->duration = 0;
        }
    }

    public function searchAvailability()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $this->showResults = true;
    }

    public function selectSlot($doctorId, $time)
    {
        $this->doctor_id = $doctorId;
        $this->start_time = date('H:i', strtotime($time));
        $this->end_time = date('H:i', strtotime($time . ' +30 minutes'));
        $this->calculateDuration();
    }

    public function save()
    {
        $this->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'reason' => 'required',
        ]);

        $this->calculateDuration();

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => $this->duration > 0 ? $this->duration : 30,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cita Registrada!',
            'text' => 'La cita médica se ha guardado correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $dayOfWeek = date('w', strtotime($this->date));
        
        $searchResults = [];
        if ($this->showResults) {
            $query = Doctor::with(['user', 'schedules']);
            
            if ($this->specialty) {
                $query->where('specialty', $this->specialty);
            }

            $searchResults = $query->get();
        }

        return view('livewire.admin.appointments.appointment-create', [
            'patients' => Patient::with('user')->get(),
            'doctors' => Doctor::with('user')->get(),
            'specialties' => Doctor::select('specialty')->distinct()->pluck('specialty'),
            'searchResults' => $searchResults,
            'dayOfWeek' => $dayOfWeek,
        ]);
    }
}
