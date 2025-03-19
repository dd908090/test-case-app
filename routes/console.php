<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('links:check-expiration')->everyMinute();
