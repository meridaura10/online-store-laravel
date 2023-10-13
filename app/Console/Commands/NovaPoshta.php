<?php

namespace App\Console\Commands;

use App\Jobs\NovaPoshta\AreasJob;
use App\Jobs\NovaPoshta\CitiesJob;

use App\Jobs\NovaPoshta\WarehousesJob;
use Illuminate\Support\Facades\Queue;
use App\Models\City;
use Illuminate\Console\Command;

class NovaPoshta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:nova-poshta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AreasJob::dispatch();
        CitiesJob::dispatch();
        WarehousesJob::dispatch();
    }
}
