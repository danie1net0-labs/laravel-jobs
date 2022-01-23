<?php

namespace App\Console\Commands\MultipleQueues;

use App\Jobs\FirstQueues\MultipleQueues\{HighJob, LowJob};
use Illuminate\Console\Command;

class SendJobsCommand extends Command
{
    /** @var string */
    protected $signature = 'send-jobs';

    /** @var string */
    protected $description = 'Send jobs.';

    public function handle(): void
    {
        HighJob::dispatch()
//            ->onConnection('database')
            ->onQueue('high');

        LowJob::dispatch()
            ->onQueue('low');
    }
}
