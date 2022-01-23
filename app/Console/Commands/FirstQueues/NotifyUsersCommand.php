<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Console\Command;

class NotifyUsersCommand extends Command
{
    /** @var string */
    protected $signature = 'notify-users';

    /** @var string */
    protected $description = 'Notify all users.';

    public function handle(): void
    {
        $this->withProgressBar(User::all(), fn (User $user) => $user->notify(new UserNotification()));
    }
}
