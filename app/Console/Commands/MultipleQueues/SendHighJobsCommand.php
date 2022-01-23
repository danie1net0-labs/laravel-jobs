<?php

namespace App\Console\Commands\MultipleQueues;

use App\Jobs\FirstQueues\MultipleQueues\HighJob;
use Illuminate\Console\Command;

class SendHighJobsCommand extends Command
{
    /** @var string */
    protected $signature = 'send-high-jobs';

    /** @var string */
    protected $description = 'Send high jobs.';

    public function handle(): void
    {
        for ($i = 0; $i < 600; $i++) {
            HighJob::dispatch()->onQueue('high');
        }
    }
}
