<?php

namespace App\Jobs\FirstQueues;

use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Throwable;

class NotifyUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @throws Throwable */
    public function handle(): void
    {
//        User::all()->each(fn (User $user) => NotifyUserJob::dispatch($user));

//        User::all()->each(fn (User $user) => $user->notify(new UserNotification()));

        Bus::batch(User::all()->map(fn (User $user) => NotifyUserJob::dispatch($user))->toArray())
            ->name('Send notifications')
            ->allowFailures()
            ->dispatch();
    }
}
