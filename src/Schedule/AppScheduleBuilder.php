<?php

namespace App\Schedule;

use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

final class AppScheduleBuilder implements ScheduleBuilder {
    public function buildSchedule(Schedule $schedule): void {
        $schedule->timezone('GTM')
            ->environments('prod');

        $schedule->addCommand('app:remove-old-offers')
            ->description('Remove non interesting offers')
            ->daily()
            ->at('1');
    }
}