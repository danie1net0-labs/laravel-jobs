<?php

namespace App\Console\Commands\MultipleQueues;

use App\Jobs\FirstQueues\MultipleQueues\LowJob;
use Illuminate\Console\Command;

class SendLowJobsCommand extends Command
{
    /** @var string */
    protected $signature = 'send-low-jobs';

    /** @var string */
    protected $description = 'Send low jobs.';

    public function handle(): void
    {
        for ($i = 0; $i < 600; $i++) {
            LowJob::dispatch()->onQueue('low');
        }
    }
}
