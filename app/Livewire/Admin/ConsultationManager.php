<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', [
    'title' => 'Consulta',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'href' => '/admin/dashboard'],
        ['name' => 'Citas', 'href' => '/admin/appointments'],
        ['name' => 'Consulta'],
    ]
])]
class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $diagnosis;
    public $treatment;
    public $notes;
    public $medications = []; // List of medication objects
    public $activeTab = 'consulta';
    public $showHistoryModal = false;
    public $showMedicalHistoryModal = false;

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->diagnosis = $appointment->diagnosis;
        $this->treatment = $appointment->treatment;
        $this->notes = $appointment->notes;
        $this->medications = $appointment->prescription ?? [];
    }

    public function addMedication()
    {
        $this->medications[] = ['name' => '', 'dose' => '', 'frequency' => ''];
    }

    public function removeMedication($index)
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    public function saveConsultation()
    {
        $this->validate([
            'diagnosis' => 'required',
            'treatment' => 'required',
        ]);

        $this->appointment->update([
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment,
            'notes' => $this->notes,
            'prescription' => $this->medications,
            'status' => 2, // Completada
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Consulta Guardada!',
            'text' => 'La consulta y la receta se han registrado correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        // Consultas anteriores del mismo paciente
        $pastAppointments = Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->where(function ($query) {
                $query->where('date', '<', now()->toDateString())
                      ->orWhere(function ($q) {
                          $q->where('date', '=', now()->toDateString())
                            ->where('start_time', '<', now()->toTimeString());
                      });
            })
            ->where('status', 2) // Completadas
            ->with('doctor.user')
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.admin.consultation-manager', [
            'pastAppointments' => $pastAppointments,
        ]);
    }
}
