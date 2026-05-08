<?php

namespace App\Console\Commands;

use App\Services\AppointmentAutomationService;
use Illuminate\Console\Command;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía reportes diarios de citas a administradores y doctores (8:00 AM).';

    /**
     * Execute the console command.
     */
    public function handle(AppointmentAutomationService $automationService)
    {
        $this->info('Generando y enviando reportes diarios...');
        
        $automationService->sendDailyReports();
        
        $this->info('Reportes enviados correctamente.');
    }
}
