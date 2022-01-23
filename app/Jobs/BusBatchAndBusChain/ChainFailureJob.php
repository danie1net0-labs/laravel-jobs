<?php

namespace App\Jobs\FirstQueues\BusBatchAndBusChain;

use App\Models\User;
use App\Notifications\UserNotification;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChainFailureJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private User $user, private bool $isShouldFail = false)
    {
    }

    /** @throws Exception */
    public function handle(): void
    {
        if ($this->isShouldFail) {
            throw new Exception('Batch failure with user ' . $this->user->name);
        }

        $this->user->notify(new UserNotification());
    }
}
