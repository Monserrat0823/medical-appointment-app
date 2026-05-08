<?php

namespace App\Livewire\Admin\Doctors;

use App\Models\Doctor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.admin', [
    'title' => 'Doctores',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'href' => '/admin/dashboard'],
        ['name' => 'Doctores'],
    ]
])]
class DoctorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $doctors = Doctor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('id_number', 'like', '%' . $this->search . '%');
            })
            ->orWhere('specialty', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.doctors.doctor-index', [
            'doctors' => $doctors,
        ]);
    }
}
