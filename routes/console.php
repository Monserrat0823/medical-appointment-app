<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// Recordatorios de citas (cada hora para detectar citas exactamente 24h antes)
Schedule::command('appointment:reminders')->hourly();

// Reportes diarios a las 8:00 AM
Schedule::command('appointment:daily-reports')->dailyAt('08:00');
