<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Submission
Schedule::command('submission:send-waiting-received-reminder')->dailyAt('08:30');
Schedule::command('submission:send-pending-alert')->dailyAt('08:30');

// ESD
Schedule::command('kaizen:send-updates-email')->fridays()->at('10:00');
Schedule::command('equipment:duplicate-today')->dailyAt('07:30');
Schedule::command('flooring:duplicate-today')->dailyAt('07:30');
Schedule::command('garment:duplicate-today')->dailyAt('07:30');
Schedule::command('groundmonitorbox:duplicate-today')->dailyAt('07:30');
Schedule::command('ionizer:duplicate-today')->dailyAt('07:30');
Schedule::command('jig:duplicate-today')->dailyAt('07:30');
Schedule::command('magazine:duplicate-today')->dailyAt('07:30');
Schedule::command('packaging:duplicate-today')->dailyAt('07:30');
Schedule::command('soldering:duplicate-today')->dailyAt('07:30');
Schedule::command('worksurface:duplicate-today')->dailyAt('07:30');
Schedule::command('wriststrap:duplicate-today')->dailyAt('07:30');
Schedule::command('glovedetail:duplicate-today')->dailyAt('07:30');
Schedule::command('schedule:update-remarks')->dailyAt('15:00');

// Daily
Schedule::command('daily-checklist:create')->weekdays()->at('07:00');
Schedule::command('daily-checklist:create')->weekdays()->at('15:00');
Schedule::command('daily-checklist:create')->weekdays()->at('23:00');
Schedule::command('daily-checklist:create')->saturdays()->at('07:00');
Schedule::command('daily-checklist:create')->saturdays()->at('12:30');
Schedule::command('daily-checklist:create')->saturdays()->at('17:45');
Schedule::command('daily-checklist:check-update')->everyMinute()->when(fn() => !now()->isSunday());

// Master Sample
Schedule::command('email:pending-master-sample')->dailyAt('08:00');
