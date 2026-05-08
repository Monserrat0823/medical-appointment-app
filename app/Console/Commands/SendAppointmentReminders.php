<?php

namespace App\Console\Commands;

use App\Services\AppointmentAutomationService;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp para las citas del día siguiente (24h antes).';

    /**
     * Execute the console command.
     */
    public function handle(AppointmentAutomationService $automationService)
    {
        $this->info('Iniciando envío de recordatorios...');
        
        $count = $automationService->sendRemindersForTomorrow();
        
        $this->info("Se han enviado {$count} recordatorios.");
    }
}
