<?php

use Sodecl\Scheduler\Schedule;
use Sodecl\Scheduler\ScheduleConfig;
use Sodecl\Scheduler\TimeSlot;

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

    // $scheduleConfig = new ScheduleConfig($openingHour, $closingHour, true, $lunchBreakStart, $lunchBreakDuration, $scheduleSize, $days, $scheduleStart, $scheduleEnd);
    $scheduleConfig = ScheduleConfig::make()
        ->days($days)
        ->openingHour($openingHour)
        ->scheduleStart($scheduleStart)
        ->scheduleEnd($scheduleEnd)
        ->lunchBreak()
        ->lunchBreakStart($lunchBreakStart)
        ->lunchBreakDuration($lunchBreakDuration)
        ->slotMinutes($slotMinutes);

    $schedule = new Schedule($scheduleConfig);

    $slots = $schedule->timeSlotsFor(today());

    $this->assertCount(8, $slots);

    $expectedSlots = [
        new TimeSlot(today()->setTimeFrom('08:00'), today()->setTimeFrom('09:00')),
        new TimeSlot(today()->setTimeFrom('09:00'), today()->setTimeFrom('10:00')),
        new TimeSlot(today()->setTimeFrom('10:00'), today()->setTimeFrom('11:00')),
        new TimeSlot(today()->setTimeFrom('11:00'), today()->setTimeFrom('12:00')),
        new TimeSlot(today()->setTimeFrom('13:00'), today()->setTimeFrom('14:00')),
        new TimeSlot(today()->setTimeFrom('14:00'), today()->setTimeFrom('15:00')),
        new TimeSlot(today()->setTimeFrom('15:00'), today()->setTimeFrom('16:00')),
        new TimeSlot(today()->setTimeFrom('16:00'), today()->setTimeFrom('17:00')),
    ];
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

    $scheduleConfig = ScheduleConfig::make()
        ->noLunchBreak()
        ->closingHour($closingHour)
        ->scheduleStart($scheduleStart)
        ->scheduleEnd($scheduleEnd)
        ->days($days)
        ->slotMinutes($scheduleSize);

    $schedule = new Schedule($scheduleConfig);

    $dateFor = today()->nextWeekday();

    $taken = [$dateFor->setTimeFrom('09:30')->format('Y-m-d H:i'), $dateFor->setTimeFrom('11:45')->format('Y-m-d H:i')];

    $slots = $schedule->timeSlotsFor($dateFor, $taken);

    $expectedSlots = [
        ['start' => '08:00', 'end' => '08:15'],
        ['start' => '08:15', 'end' => '08:30'],
        ['start' => '08:30', 'end' => '08:45'],
        ['start' => '08:45', 'end' => '09:00'],
        ['start' => '09:00', 'end' => '09:15'],
        ['start' => '09:15', 'end' => '09:30'],
        ['start' => '09:45', 'end' => '10:00'],
        ['start' => '10:00', 'end' => '10:15'],
        ['start' => '10:15', 'end' => '10:30'],
        ['start' => '10:30', 'end' => '10:45'],
        ['start' => '10:45', 'end' => '11:00'],
        ['start' => '11:00', 'end' => '11:15'],
        ['start' => '11:15', 'end' => '11:30'],
        ['start' => '11:30', 'end' => '11:45'],
    ];

    $expectedSlots = [
        new TimeSlot($dateFor->clone()->setTimeFrom('08:00'), $dateFor->clone()->setTimeFrom('08:15')),
        new TimeSlot($dateFor->clone()->setTimeFrom('08:15'), $dateFor->clone()->setTimeFrom('08:30')),
        new TimeSlot($dateFor->clone()->setTimeFrom('08:30'), $dateFor->clone()->setTimeFrom('08:45')),
        new TimeSlot($dateFor->clone()->setTimeFrom('08:45'), $dateFor->clone()->setTimeFrom('09:00')),
        new TimeSlot($dateFor->clone()->setTimeFrom('09:00'), $dateFor->clone()->setTimeFrom('09:15')),
        new TimeSlot($dateFor->clone()->setTimeFrom('09:15'), $dateFor->clone()->setTimeFrom('09:30')),
        new TimeSlot($dateFor->clone()->setTimeFrom('09:45'), $dateFor->clone()->setTimeFrom('10:00')),
        new TimeSlot($dateFor->clone()->setTimeFrom('10:00'), $dateFor->clone()->setTimeFrom('10:15')),
        new TimeSlot($dateFor->clone()->setTimeFrom('10:15'), $dateFor->clone()->setTimeFrom('10:30')),
        new TimeSlot($dateFor->clone()->setTimeFrom('10:30'), $dateFor->clone()->setTimeFrom('10:45')),
        new TimeSlot($dateFor->clone()->setTimeFrom('10:45'), $dateFor->clone()->setTimeFrom('11:00')),
        new TimeSlot($dateFor->clone()->setTimeFrom('11:00'), $dateFor->clone()->setTimeFrom('11:15')),
        new TimeSlot($dateFor->clone()->setTimeFrom('11:15'), $dateFor->clone()->setTimeFrom('11:30')),
        new TimeSlot($dateFor->clone()->setTimeFrom('11:30'), $dateFor->clone()->setTimeFrom('11:45')),
    ];

    $this->assertCount(count($expectedSlots), $slots);
    $this->assertEquals($expectedSlots, $slots);

});
