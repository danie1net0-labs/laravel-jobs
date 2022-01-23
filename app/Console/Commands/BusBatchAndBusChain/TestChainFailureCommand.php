<?php

namespace App\Console\Commands\BusBatchAndBusChain;

use App\Jobs\FirstQueues\BusBatchAndBusChain\BatchFailureJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Throwable;
use function logger;

class TestChainFailureCommand extends Command
{
    /** @var string */
    protected $signature = 'test-chain-failure';

    /** @var string */
    protected $description = 'Test chain failure.';

    /** @throws Throwable */
    public function handle(): void
    {
        $users = User::all()->offsetGet(10)->take(3);

        $jobs = [
            new BatchFailureJob($users->get(0), true),
            new BatchFailureJob($users->get(1), false),
            new BatchFailureJob($users->get(2), false),
        ];

        //Bus::chain($batches)->dispatch();

        Bus::batch([$jobs])
            ->name('Notification users with chain in batch')
            ->catch(static function (Batch $batch, Throwable $throwable) {
                logger('Job failure: ' . $throwable->getMessage());

                $batch->cancel();
            })
            ->finally(fn () => logger("Chain 'TestChainFailure' has finished"))
            ->dispatch();
    }
}
