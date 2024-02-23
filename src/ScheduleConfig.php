<?php

namespace Sodecl\Scheduler;

use Carbon\CarbonInterface;

class ScheduleConfig
{
    public function __construct(
        public string $openingHour,
        public string $closingHour,
        public bool $lunchBreak,
        public ?string $lunchBreakStart,
        public ?int $lunchBreakDuration,
        public int $slotMinutes,
        public array $days,
        public CarbonInterface $scheduleStart,
        public CarbonInterface $scheduleEnd,
        public string $timezone = 'UTC',
    ) {
    }

    public static function make(): self
    {
        // return some sensible defaults
        return new self(
            openingHour: '08:00',
            closingHour: '17:00',
            lunchBreak: true,
            lunchBreakStart: '12:00',
            lunchBreakDuration: 60,
            slotMinutes: 60,
            days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            scheduleStart: now()->startOfMonth()->setTimeFrom('08:00'),
            scheduleEnd: now()->endOfMonth()->setTimeFrom('17:00')
        );
    }

    public function openingHour(string $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function closingHour(string $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }

    public function lunchBreak(): self
    {
        $this->lunchBreak = true;

        return $this;
    }

    public function noLunchBreak(): self
    {
        $this->lunchBreak = false;
        $this->lunchBreakStart = null;
        $this->lunchBreakDuration = null;

        return $this;
    }

    public function lunchBreakStart(string $lunchBreakStart): self
    {
        $this->lunchBreakStart = $lunchBreakStart;

        return $this;
    }

    public function lunchBreakDuration(int $lunchBreakDuration): self
    {
        $this->lunchBreakDuration = $lunchBreakDuration;

        return $this;
    }

    public function slotMinutes(int $slotMinutes): self
    {
        $this->slotMinutes = $slotMinutes;

        return $this;
    }

    public function days(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function scheduleStart(CarbonInterface $scheduleStart): self
    {
        $this->scheduleStart = $scheduleStart;

        return $this;
    }

    public function scheduleEnd(CarbonInterface $scheduleEnd): self
    {
        $this->scheduleEnd = $scheduleEnd;

        return $this;
    }

    public function timezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
}
