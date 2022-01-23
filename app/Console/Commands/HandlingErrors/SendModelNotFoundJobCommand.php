<?php

namespace App\Console\Commands\HandlingErrors;

use App\Jobs\FirstQueues\HandlingErrors\ModelNotFoundJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendModelNotFoundJobCommand extends Command
{
    /** @var string */
    protected $signature = 'send-model-not-found-job';

    /** @var string */
    protected $description = 'Send model not found jobs.';

    public function handle(): void
    {
        $deletedUser = User::factory()->create();

        $deletedUser->delete();

        ModelNotFoundJob::dispatch($deletedUser);

        $user = User::factory()->create();

        ModelNotFoundJob::dispatch($user);
    }
}
