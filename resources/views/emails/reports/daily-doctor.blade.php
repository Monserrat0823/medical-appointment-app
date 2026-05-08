<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7fafc; margin: 0; padding: 40px; }
        .container { max-width: 650px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border-top: 6px solid #38a169; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .content { padding: 40px; }
        .greeting { font-size: 20px; color: #2d3748; font-weight: bold; margin-bottom: 10px; }
        .date-info { color: #718096; margin-bottom: 30px; font-size: 14px; }
        
        .agenda-card { border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 15px; padding: 15px; display: table; width: 100%; box-sizing: border-box; }
        .time-box { display: table-cell; width: 80px; vertical-align: top; color: #38a169; font-weight: bold; font-size: 16px; border-right: 1px solid #e2e8f0; padding-right: 15px; }
        .patient-info { display: table-cell; padding-left: 15px; vertical-align: top; }
        .patient-name { font-weight: bold; color: #2d3748; margin-bottom: 4px; }
        .reason { font-size: 13px; color: #718096; font-style: italic; }
        
        .empty-state { text-align: center; padding: 40px; color: #a0aec0; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #cbd5e0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="greeting">Hola Dr. {{ $doctor->user->name }},</div>
            <div class="date-info">Esta es su agenda de pacientes para hoy, <strong>{{ now()->format('d/m/Y') }}</strong>.</div>

            @if($appointments->isEmpty())
                <div class="empty-state">
                    Usted no tiene citas programadas para el día de hoy.
                </div>
            @else
                @foreach($appointments as $appointment)
                    <div class="agenda-card">
                        <div class="time-box">{{ $appointment->start_time }}</div>
                        <div class="patient-info">
                            <div class="patient-name">{{ $appointment->patient->user->name }}</div>
                            <div class="reason">{{ $appointment->reason }}</div>
                        </div>
                    </div>
                @endforeach
            @endif

            <p style="margin-top: 30px; font-size: 14px; color: #4a5568;">
                Le deseamos una productiva jornada laboral.
            </p>
        </div>
        <div class="footer">
            Sistema Healthify &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
