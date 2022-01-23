<?php

namespace App\Console\Commands\BusBatchAndBusChain;

use App\Jobs\FirstQueues\BusBatchAndBusChain\BatchFailureJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Throwable;
use function logger;

class TestBatchFailureCommand extends Command
{
    /** @var string */
    protected $signature = 'test-batch-failure';

    /** @var string */
    protected $description = 'Test batch failure.';

    /** @throws Throwable */
    public function handle(): void
    {
        $users = User::all()->take(3);

        $batches = [
            new BatchFailureJob($users->get(0), true),
            new BatchFailureJob($users->get(1), false),
            new BatchFailureJob($users->get(2), false),
        ];

        Bus::batch($batches)
            ->name('Notification users')
            ->catch(static function (Batch $batch, Throwable $throwable) {
                logger('Job failure: ' . $throwable->getMessage());

                $batch->cancel();
            })
            ->finally(fn () => logger("Batch 'TestBatchFailure' has finished"))
            ->dispatch();
    }
}
