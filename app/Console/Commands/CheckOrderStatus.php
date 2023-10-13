<?php

namespace App\Console\Commands;

use App\Jobs\Payment\CheckOrderStatus as PaymentCheckOrderStatus;
use Illuminate\Console\Command;

class CheckOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check-order-status';

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
        PaymentCheckOrderStatus::dispatch();
    }
}
