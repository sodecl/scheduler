<?php

use Sodecl\Scheduler\Schedule;
use Sodecl\Scheduler\ScheduleConfig;

test('calculate for 1 hour blocks', function () {

    $openingHour = '08:00';

    $closingHour = '17:00';

    $lunchBreakStart = '12:00';

    $lunchBreakDuration = 60;

    $slotMinutes = '60';

    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    $scheduleStart = now()->startOfMonth()->setTimeFrom($openingHour);
    $scheduleEnd = now()->endOfMonth()->setTimeFrom($closingHour);

    $this->assertEquals(now()->startOfMonth()->format('Y-m-d ').$openingHour, $scheduleStart->format('Y-m-d H:i'));

    $this->assertEquals(now()->endOfMonth()->format('Y-m-d ').$closingHour, $scheduleEnd->format('Y-m-d H:i'));

    
    $scheduleConfig = new ScheduleConfig($openingHour, $closingHour, true, $lunchBreakStart, $lunchBreakDuration, $slotMinutes, $days, $scheduleStart, $scheduleEnd);
    // $scheduleConfig = ScheduleConfig::make()
    //     ->days($days)
    //     ->openingHour($openingHour)
    //     ->scheduleStart($scheduleStart)
    //     ->scheduleEnd($scheduleEnd)
    //     ->lunchBreak()
    //     ->lunchBreakStart($lunchBreakStart)
    //     ->lunchBreakDuration($lunchBreakDuration)
    //     ->slotMinutes($slotMinutes);

    $schedule = new Schedule($scheduleConfig);

    $slots = $schedule->timeSlotsFor(today());


    $this->assertCount(8, $slots);

    $expectedSlots = [
        ['start'=> '08:00', 'end' => '09:00'],
        ['start'=> '09:00', 'end' => '10:00'],
        ['start'=> '10:00', 'end' => '11:00'],
        ['start'=> '11:00', 'end' => '12:00'],
        ['start'=> '13:00', 'end' => '14:00'],
        ['start'=> '14:00', 'end' => '15:00'],
        ['start'=> '15:00', 'end' => '16:00'],
        ['start'=> '16:00', 'end' => '17:00'],
    ];

    $expectedSlots = array_map(function($slot) {
        return [
            'start' => today()->format('Y-m-d ').$slot['start'],
            'end' => today()->format('Y-m-d ').$slot['end']
        ];
    }, $expectedSlots);

    $this->assertEquals($expectedSlots, $slots);
});

test('calculate for 15 minute blocks', function () {

    $openingHour = '08:00';

    $closingHour = '12:00';

    $lunchBreakStart = '12:00';

    $lunchBreakDuration = 60;

    $scheduleSize = '15';

    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    $scheduleStart = now()->startOfMonth()->setTimeFrom($openingHour);
    $scheduleEnd = now()->endOfMonth()->setTimeFrom($closingHour);

    $this->assertEquals(now()->startOfMonth()->format('Y-m-d ').$openingHour, $scheduleStart->format('Y-m-d H:i'));

    $this->assertEquals(now()->endOfMonth()->format('Y-m-d ').$closingHour, $scheduleEnd->format('Y-m-d H:i'));

    
    $scheduleConfig = new ScheduleConfig($openingHour, $closingHour, true, $lunchBreakStart, $lunchBreakDuration, $scheduleSize, $days, $scheduleStart, $scheduleEnd);

    $schedule = new Schedule($scheduleConfig);

    $slots = $schedule->timeSlotsFor(today());


    $this->assertCount(16, $slots);

    $expectedSlots = [
        ['start'=> '08:00', 'end' => '09:00'],
        ['start'=> '09:00', 'end' => '10:00'],
        ['start'=> '10:00', 'end' => '11:00'],
        ['start'=> '11:00', 'end' => '12:00'],
        ['start'=> '13:00', 'end' => '14:00'],
        ['start'=> '14:00', 'end' => '15:00'],
        ['start'=> '15:00', 'end' => '16:00'],
        ['start'=> '16:00', 'end' => '17:00'],
    ];

    $expectedSlots = array_map(function($slot) {
        return [
            'start' => today()->format('Y-m-d ').$slot['start'],
            'end' => today()->format('Y-m-d ').$slot['end']
        ];
    }, $expectedSlots);

    $this->assertEquals($expectedSlots, $slots);
});

function now()
{
    return new Carbon\Carbon();
}

function today()
{
    return now()->today();
}
