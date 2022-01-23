<?php

use Illuminate\Bus\BatchRepository;
use App\Jobs\FirstQueues\{MakeOrderJob, NotifyUsersJob, RunPaymentJob};
use App\Jobs\FirstQueues\ValidateCardJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static fn () => view('welcome'));

Route::get('notify-users', static function () {
    NotifyUsersJob::dispatch();

    return 'Ok';
});

Route::get('run-batch', static function () {
    Bus::batch([
        new MakeOrderJob(),
        new ValidateCardJob(),
        new RunPaymentJob()
    ])
    ->name('Run batch example ' . random_int(1, 10))
    ->dispatch();

    return 'Ok';
});

Route::get('batches', static function (BatchRepository $batchRepository) {
    return [
        'batches' => $batchRepository->get(),
    ];
});