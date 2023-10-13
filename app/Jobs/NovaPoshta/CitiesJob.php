<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshtaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CitiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page = 1;
    protected $limit = 1000;
    protected $service;

    public function __construct($page = 1, $limit = 1000)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->service = new NovaPoshtaService;
    }

    public function handle()
    {
        while (true) {
            $data = $this->service->get('getCities', $this->page, $this->limit);

            if (!$data) {
                break;
            }

            $this->service->updateOrCreateCities($data);
            $this->page++;
        }
    }
}
