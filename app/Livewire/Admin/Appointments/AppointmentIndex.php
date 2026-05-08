<?php

namespace App\Livewire\Admin\Appointments;

use App\Models\Appointment;
use Livewire\Attributes\Layout; 
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', [
    'title' => 'Citas',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'href' => '/admin/dashboard'],
        ['name' => 'Citas'],
    ]
])]
class AppointmentIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteAppointment($id)
    {
        Appointment::find($id)->delete();
        session()->flash('success', 'Cita eliminada correctamente.');
    }

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where(function($query) {
                $query->whereHas('patient.user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('doctor.user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.appointments.appointment-index', [
            'appointments' => $appointments,
        ]);
    }
}
