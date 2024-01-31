<?php

namespace App\Console\Commands;

use App\Http\Controllers\MonitorController;
use Illuminate\Console\Command;

class MonitorWebcronCommand extends Command
{

    public $signature = 'custom:monitorweb';
    public $description = 'Monitor de Servicio de Paginas Web';

    public function handle()
    {
        info("Ejecutando monitorweb");
        $controller = new MonitorController;
        $controller->monitorWebcron();
    }
}
