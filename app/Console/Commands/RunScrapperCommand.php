<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ScrapperService;

class RunScrapperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run-scrapper-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ScrapperService $scrapperService)
    {
        $scrapperService->handle();
    }

}
