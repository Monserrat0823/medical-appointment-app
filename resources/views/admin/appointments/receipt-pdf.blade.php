<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; color: #2c3e50; line-height: 1.5; margin: 0; padding: 0; background-color: #fcfcfc; }
        .container { padding: 40px; }
        .header { background-color: #3498db; color: white; padding: 30px 40px; text-align: center; }
        .logo { font-size: 32px; font-weight: bold; letter-spacing: 2px; }
        .subtitle { font-size: 14px; opacity: 0.9; margin-top: 5px; text-transform: uppercase; }
        
        .card { background: white; border-radius: 10px; padding: 30px; margin-top: -20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #edf2f7; }
        .folio { text-align: right; font-size: 14px; color: #7f8c8d; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .section-header { border-bottom: 2px solid #3498db; margin-bottom: 15px; padding-bottom: 5px; }
        .section-title { font-size: 15px; font-weight: bold; color: #3498db; text-transform: uppercase; }
        
        td { padding: 12px 5px; font-size: 14px; border-bottom: 1px solid #f1f4f8; }
        .label { width: 35%; color: #7f8c8d; font-weight: 600; }
        .value { width: 65%; color: #2c3e50; font-weight: bold; }
        
        .reason-box { background-color: #f8fbfe; border-left: 4px solid #3498db; padding: 15px; font-style: italic; color: #5d6d7e; margin-top: 10px; }
        
        .footer { text-align: center; margin-top: 40px; padding: 20px 40px; font-size: 12px; color: #bdc3c7; border-top: 1px solid #eee; }
        .status-badge { background-color: #27ae60; color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">HEALTHIFY</div>
        <div class="subtitle">Sistema de Gestión Médica Integral</div>
    </div>

    <div class="container">
        <div class="card">
            <div class="folio">
                <strong>FOLIO:</strong> #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}<br>
                <strong>FECHA EMISIÓN:</strong> {{ $generated_at }}
            </div>

            <div class="section-header">
                <span class="section-title">Detalles de la Cita</span>
            </div>
            <table>
                <tr>
                    <td class="label">Fecha de la Cita:</td>
                    <td class="value">{{ $appointment->date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Horario:</td>
                    <td class="value">{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                </tr>
                <tr>
                    <td class="label">Estado actual:</td>
                    <td class="value"><span class="status-badge">Confirmada</span></td>
                </tr>
            </table>

            <div class="section-header">
                <span class="section-title">Información del Paciente</span>
            </div>
            <table>
                <tr>
                    <td class="label">Nombre Completo:</td>
                    <td class="value">{{ $appointment->patient->user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Identificación:</td>
                    <td class="value">{{ $appointment->patient->user->id_number ?? 'No registrada' }}</td>
                </tr>
            </table>

            <div class="section-header">
                <span class="section-title">Especialista Asignado</span>
            </div>
            <table>
                <tr>
                    <td class="label">Médico:</td>
                    <td class="value">Dr. {{ $appointment->doctor->user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Especialidad:</td>
                    <td class="value">{{ $appointment->doctor->specialty }}</td>
                </tr>
            </table>

            <div class="section-header">
                <span class="section-title">Motivo de Consulta</span>
            </div>
            <div class="reason-box">
                "{{ $appointment->reason }}"
            </div>
        </div>

        <div class="footer">
            <p>Este documento es un comprobante oficial de su cita programada.</p>
            <p>Por políticas de la clínica, agradecemos llegar 15 minutos antes de su horario. <br>
            Si requiere cancelar, favor de hacerlo mediante el portal o llamando a recepción.</p>
        </div>
    </div>
</body>
</html>
