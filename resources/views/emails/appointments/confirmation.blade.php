<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; padding: 20px; }
        .card { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { color: #4a90e2; font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        .content { font-size: 16px; color: #555; line-height: 1.5; }
        .footer { margin-top: 30px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">Healthify</div>
        <div class="content">
            @if($type === 'patient')
                <p>Hola <strong>{{ $appointment->patient->user->name }}</strong>,</p>
                <p>Tu cita médica ha sido agendada exitosamente. Adjunto a este correo encontrarás el comprobante con todos los detalles.</p>
            @else
                <p>Estimado/a <strong>Dr. {{ $appointment->doctor->user->name }}</strong>,</p>
                <p>Se ha agendado una nueva cita con el paciente <strong>{{ $appointment->patient->user->name }}</strong>.</p>
            @endif

            <p><strong>Detalles:</strong></p>
            <ul>
                <li>Fecha: {{ $appointment->date->format('d/m/Y') }}</li>
                <li>Hora: {{ $appointment->start_time }}</li>
                <li>Motivo: {{ $appointment->reason }}</li>
            </ul>
        </div>
        <div class="footer">
            Este es un mensaje automático, por favor no respondas a este correo.
        </div>
    </div>
</body>
</html>
