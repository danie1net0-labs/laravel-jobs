<?php

namespace App\Providers;

use App\Notifications\JobFailedNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\{Notification, Queue, RateLimiter};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('jobs', static fn () => Limit::perMinute(10));

        Queue::failing(static function (JobFailed $event) {
            Notification::route('mail', 'jobs@laravel.com')->notify(new JobFailedNotification($event));
        });
    }
}
