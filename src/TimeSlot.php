<?php

namespace Sodecl\Scheduler;

use Carbon\CarbonInterface;

class TimeSlot
{
    public function __construct(
        public CarbonInterface $start,
        public ?CarbonInterface $end = null,
        array $data = []
    ) {
    }
}
