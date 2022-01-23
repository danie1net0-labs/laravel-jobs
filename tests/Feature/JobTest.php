<?php

namespace Tests\Feature;

use App\Jobs\FirstQueues\NotifyUsersJob;
use Bus;
use Tests\TestCase;

class JobTest extends TestCase
{
    /** @test */
    public function dispatch_job(): void
    {
        Bus::fake();

        $this->get('notify-users')->assertOk();

        Bus::assertDispatched(NotifyUsersJob::class, static function (NotifyUsersJob $job) {
            // additional test here...
            return true;
        });
    }
}
