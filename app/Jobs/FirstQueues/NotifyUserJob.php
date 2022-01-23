<?php

namespace App\Jobs\FirstQueues;

use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Bus\{Batchable, Queueable};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;

class NotifyUserJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 0;

    public function __construct(private User $user)
    {
    }

//    public function middleware(): array
//    {
//        return [
//            new RateLimited('jobs'),
//        ];
//    }

    public function handle(): void
    {
        $this->user->notify(new UserNotification());
    }
}
