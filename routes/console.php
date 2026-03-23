<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('submission:send-waiting-received-reminder')
    ->dailyAt('08:00');

Schedule::command('submission:send-pending-alert')
    ->dailyAt('08:00');
