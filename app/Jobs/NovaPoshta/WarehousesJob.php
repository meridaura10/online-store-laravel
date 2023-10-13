<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshtaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WarehousesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $page = 1;
    protected $limit = 1000;

    public function __construct($page = 1, $limit = 1000)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    public function handle(NovaPoshtaService $novaPoshtaService)
    {
        while (true) {
            $data = $novaPoshtaService->get('getWarehouses', $this->page, $this->limit);

 

            if (!$data) {
                break;
            }
   
            $novaPoshtaService->updateOrCreateWarehouses($data);
            $this->page++;

        }
    }
}
