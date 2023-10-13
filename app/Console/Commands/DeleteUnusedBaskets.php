<?php

namespace App\Console\Commands;

use App\Jobs\DeleteUnusedBasketsJob;
use Illuminate\Console\Command;

class DeleteUnusedBaskets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:delete-unused-baskets';

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
        DeleteUnusedBasketsJob::dispatch();
    }
}
