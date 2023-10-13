<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a:ref';

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
        $this->info('Refreshing database...');
        $this->call('migrate:refresh'); 

        $this->info('Seeding data...');
        $this->call('db:seed'); 

        $this->info('schedule start...');
        $this->call('schedule:run'); 

        $this->info('queue work...');
        $this->call('queue:work');
    }
}
