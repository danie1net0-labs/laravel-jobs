<?php

namespace App\Jobs\FirstQueues\MultipleQueues;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HighJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
//        $this->queue = 'high';
//        $this->connection = 'database';
    }

    public function handle(): void
    {
        sleep(2);

        logger('High job send', [
            'job' => self::class,
            'queue' => $this->queue,
            'connection' => $this->connection,
        ]);
    }
}
