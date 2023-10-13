<?php

namespace App\Console\Commands;

use App\Jobs\Payment\CheckStatusPayment as PaymentCheckStatusPayment;
use Illuminate\Console\Command;

class CheckStatusPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:check-status-payment';

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
        PaymentCheckStatusPayment::dispatch();
    }
}
