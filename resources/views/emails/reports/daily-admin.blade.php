<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4f8; margin: 0; padding: 40px; }
        .container { max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .header { background: #1a365d; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 40px; }
        .stats { display: flex; justify-content: space-between; margin-bottom: 30px; background: #f8fafc; padding: 20px; border-radius: 8px; }
        .stat-item { text-align: center; flex: 1; }
        .stat-value { display: block; font-size: 24px; font-weight: bold; color: #2d3748; }
        .stat-label { font-size: 12px; color: #718096; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; font-size: 13px; color: #718096; text-transform: uppercase; padding: 12px 15px; border-bottom: 2px solid #edf2f7; }
        td { padding: 15px; font-size: 14px; color: #2d3748; border-bottom: 1px solid #edf2f7; }
        .time { font-weight: bold; color: #3182ce; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #a0aec0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte General de Citas</h1>
            <p style="margin: 5px 0 0; opacity: 0.8;">{{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="content">
            <div class="stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $appointments->count() }}</span>
                    <span class="stat-label">Citas de hoy</span>
                </div>
            </div>

            @if($appointments->isEmpty())
                <p style="text-align: center; color: #718096; padding: 40px;">No hay citas programadas para el día de hoy.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Horario</th>
                            <th>Paciente</th>
                            <th>Especialista</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="time">{{ $appointment->start_time }}</td>
                                <td>{{ $appointment->patient->user->name }}</td>
                                <td>Dr. {{ $appointment->doctor->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="footer">
            Sistemas Healthify - Generado automáticamente a las 08:00 AM
        </div>
    </div>
</body>
</html>
