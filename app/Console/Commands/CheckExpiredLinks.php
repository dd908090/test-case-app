<?php

namespace App\Console\Commands;

use App\Service\CronJobService;
use Illuminate\Console\Command;

class CheckExpiredLinks extends Command
{

    private CronJobService $cronJobService;
    public function __construct(CronJobService $cronJobService)
    {
        parent::__construct();
        $this->cronJobService = $cronJobService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check-expiration';

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
        $this->cronJobService->checkExpiredLinks();
        \Log::info('CheclExpiredLinks complited ' . now());
    }
}
