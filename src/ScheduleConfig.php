<?php

namespace Sodecl\Scheduler;

use Carbon\Carbon;

class ScheduleConfig
{
    public function __construct(
        public string $openingHour = '08:00',
        public string $closingHour = '17:00',
        public bool $lunchBreak = true,
        public string $lunchBreakStart = '12:00',
        public int $lunchBreakDuration = 60,
        public int $slotMinutes = 60,
        public array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
        public Carbon $scheduleStart = null,
        public Carbon $scheduleEnd = null,
    ) {
    }

    public static function make(): self {
        return new self();
    }

    public function openingHour(string $openingHour): self {
        $this->openingHour = $openingHour;
        return $this;
    }

    public function closingHour(string $closingHour): self {
        $this->closingHour = $closingHour;
        return $this;
    }

    public function lunchBreak(): self {
        $this->lunchBreak = true;
        return $this;
    }

    public function noLunchBreak(): self {
        $this->lunchBreak = false;
        $this->lunchBreakStart = null;
        $this->lunchBreakDuration = null;
        return $this;
    }

    public function lunchBreakStart(string $lunchBreakStart): self {
        $this->lunchBreakStart = $lunchBreakStart;
        return $this;
    }

    public function lunchBreakDuration(int $lunchBreakDuration): self {
        $this->lunchBreakDuration = $lunchBreakDuration;
        return $this;
    }

    public function slotMinutes(int $slotMinutes): self {
        $this->slotMinutes = $slotMinutes;
        return $this;
    }

    public function days(array $days): self {
        $this->days = $days;
        return $this;
    }

    public function scheduleStart(Carbon $scheduleStart): self {
        $this->scheduleStart = $scheduleStart;
        return $this;
    }

    public function scheduleEnd(Carbon $scheduleEnd): self {
        $this->scheduleEnd = $scheduleEnd;
        return $this;
    }
}
