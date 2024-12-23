<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('timecard:cron')->dailyAt('00:00')
->sendOutputTo(storage_path('logs/schedule.log'));
// Schedule::command('timecard:cron')->everyMinute();
