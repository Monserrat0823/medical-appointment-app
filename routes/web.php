<?php

use    Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin Appointments Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/appointments', \App\Livewire\Admin\Appointments\AppointmentIndex::class)->name('appointments.index');
        Route::get('/appointments/create', \App\Livewire\Admin\Appointments\AppointmentCreate::class)->name('appointments.create');
        Route::get('/doctors', \App\Livewire\Admin\Doctors\DoctorIndex::class)->name('doctors.index');
        Route::get('/doctors/{doctor}/schedule', \App\Livewire\Admin\Doctors\DoctorSchedule::class)->name('doctors.schedule');
        Route::get('/consultation/{appointment}', \App\Livewire\Admin\ConsultationManager::class)->name('consultation');
    });
}); 
?>