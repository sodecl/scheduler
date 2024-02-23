<?php

namespace Sodecl\Scheduler;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class Schedule
{
    public function __construct(
        protected ScheduleConfig $config
    ) {
    }


    public function timeSlotsFor(CarbonInterface $date, array $slotsTaken = []): array
    {
        $slots = [];
        $start = Carbon::parse($date->format('Y-m-d') . ' ' . $this->config->openingHour);
        $end = Carbon::parse($date->format('Y-m-d') . ' ' . $this->config->closingHour);

        if($date->gt($this->config->scheduleEnd)) {
            return $slots;
        }

        if($date->lt($this->config->scheduleStart)) {
            return $slots;
        }

        if (!in_array(strtolower($date->englishDayOfWeek), $this->config->days)) {
            return $slots;
        }

        $lunchStart = $this->config->lunchBreakStart;

        $lunchStart = Carbon::parse($date->format('Y-m-d') . ' ' . $lunchStart);
        $lunchEnd = Carbon::parse($lunchStart->format('Y-m-d H:i'))->addMinutes($this->config->lunchBreakDuration);
        $interval = $this->config->slotMinutes;
        while ($start < $end) {
            if ($start->between($lunchStart, $lunchEnd)) {
                $start = $lunchEnd;
            }

            // check if slot is already taken
            if (in_array($start->format('Y-m-d H:i'), $slotsTaken)) {
                $start = $start->addMinutes($interval);
                continue;
            }

            $slotEnd = $start->clone()->addMinutes($interval);
            $slots[] = ['start' => $start->format('Y-m-d H:i'), 'end' => $slotEnd->format('Y-m-d H:i')];
            $start = $start->addMinutes($interval);
        }
        return $slots;
    }
}
