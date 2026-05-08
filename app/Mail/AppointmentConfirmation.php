<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfContent;
    public $type; // 'patient' or 'doctor'

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $pdfContent, $type = 'patient')
    {
        $this->appointment = $appointment;
        $this->pdfContent = $pdfContent;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'patient' 
            ? 'Confirmación de tu Cita Médica' 
            : 'Nueva Cita Agendada - ' . $this->appointment->patient->user->name;

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'comprobante-cita.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
