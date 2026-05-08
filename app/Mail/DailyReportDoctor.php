<?php

namespace App\Mail;

use App\Models\Doctor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyReportDoctor extends Mailable
{
    use Queueable, SerializesModels;

    public $appointments;
    public $doctor;

    public function __construct(Collection $appointments, Doctor $doctor)
    {
        $this->appointments = $appointments;
        $this->doctor = $doctor;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agenda del Día - ' . now()->format('d/m/Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reports.daily-doctor',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
