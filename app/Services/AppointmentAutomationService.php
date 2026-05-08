<?php

namespace App\Services;

use App\Models\Appointment;
use App\Mail\AppointmentConfirmation;
use App\Mail\DailyReportAdmin;
use App\Mail\DailyReportDoctor;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AppointmentAutomationService
{
    protected $whatsApp;

    public function __construct(WhatsAppService $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }

    /**
     * Procesa una nueva cita: Genera PDF, envía correos y WhatsApp.
     */
    public function processNewAppointment(Appointment $appointment)
    {
        try {
            // 1. Generar PDF
            $pdf = $this->generateReceiptPdf($appointment);
            
            // 2. Enviar correos (Paciente y Doctor)
            $this->sendConfirmationEmails($appointment, $pdf);

            // 3. Enviar WhatsApp (Paciente)
            $this->sendWhatsAppConfirmation($appointment);

            return true;
        } catch (\Exception $e) {
            Log::error("Error procesando automatización de cita #{$appointment->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Genera el contenido del PDF del comprobante.
     */
    public function generateReceiptPdf(Appointment $appointment)
    {
        $data = [
            'appointment' => $appointment->load(['patient.user', 'doctor.user']),
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        return Pdf::loadView('admin.appointments.receipt-pdf', $data)->output();
    }

    /**
     * Envía correos de confirmación con el PDF adjunto.
     */
    protected function sendConfirmationEmails(Appointment $appointment, $pdfContent)
    {
        $patientEmail = $appointment->patient->user->email;
        $doctorEmail = $appointment->doctor->user->email;

        // Correo al Paciente
        Mail::to($patientEmail)->send(new AppointmentConfirmation($appointment, $pdfContent, 'patient'));

        // Correo al Doctor
        Mail::to($doctorEmail)->send(new AppointmentConfirmation($appointment, $pdfContent, 'doctor'));
    }

    /**
     * Envía mensaje de confirmación por WhatsApp.
     */
    protected function sendWhatsAppConfirmation(Appointment $appointment)
    {
        $phone = $appointment->patient->user->phone;
        $patientName = $appointment->patient->user->name;
        $date = $appointment->date->format('d/m/Y');
        $time = $appointment->start_time;

        $message = "Hola {$patientName}, tu cita médica ha sido agendada para el día {$date} a las {$time}. ¡Te esperamos!";
        
        $this->whatsApp->sendMessage($phone, $message);
    }

    /**
     * Envía recordatorios para citas de mañana.
     */
    public function sendRemindersForTomorrow()
    {
        $tomorrow = now()->addDay()->format('Y-m-d');
        $appointments = Appointment::where('date', $tomorrow)
            ->where('status', 1) // Suponiendo 1 = Pendiente/Activa
            ->with(['patient.user'])
            ->get();

        foreach ($appointments as $appointment) {
            $phone = $appointment->patient->user->phone;
            $name = $appointment->patient->user->name;
            $time = $appointment->start_time;
            
            $message = "Recordatorio: Mañana tienes una cita médica a las {$time}. Por favor confirma tu asistencia.";
            $this->whatsApp->sendMessage($phone, $message);
        }

        return $appointments->count();
    }

    /**
     * Genera y envía los reportes diarios a Admin y Doctores.
     */
    public function sendDailyReports()
    {
        $today = now()->format('Y-m-d');
        
        // 1. Reporte para Administrador (Todas las citas de hoy)
        $allAppointments = Appointment::where('date', $today)
            ->with(['patient.user', 'doctor.user'])
            ->get();

        $admins = User::role('Administrador')->get(); 
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new DailyReportAdmin($allAppointments));
        }

        // 2. Reporte para cada Doctor
        $doctors = Doctor::with('user')->get();
        foreach ($doctors as $doctor) {
            $doctorAppointments = Appointment::where('date', $today)
                ->where('doctor_id', $doctor->id)
                ->with(['patient.user'])
                ->get();

            if ($doctorAppointments->isNotEmpty()) {
                Mail::to($doctor->user->email)->send(new DailyReportDoctor($doctorAppointments, $doctor));
            }
        }
    }
}
