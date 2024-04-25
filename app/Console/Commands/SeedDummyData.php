<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed first data required for system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $commands =[
            'db:seed SeedUser',
            'db:seed SeedRestaurant',
            'db:seed SeedMenu',
            'db:seed SeedRole',
            'db:seed SeedAdminAndManager',
            'db:seed SeedTestingAccount',
        ];

        foreach($commands as $command) {
            $this->info("running command ".$command);
            Artisan::call($command);
            $this->info("finish running command ".$command);

        }
        return Command::SUCCESS;
    }
}
