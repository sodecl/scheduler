# Sodecl Scheduler Library

## Introduction
Sodecl Scheduler is a PHP library designed for creating and managing a customizable schedule of time slots. It's particularly useful for applications that require precise control over operational hours, appointments, breaks, and scheduling constraints. Leveraging the Carbon library for date and time manipulation, Sodecl Scheduler offers a powerful yet flexible way to handle complex scheduling needs.

## Features
- Flexible time slot configuration (e.g., 1 hour or 15 minutes blocks).
- Customizable working days and operational hours.
- Support for managing lunch breaks within the schedule.
- Ability to exclude specific time slots.
- Integration with Carbon for robust date and time handling.

## Installation
To install the Sodecl Scheduler, you will need Composer, a dependency manager for PHP.

Run the following command in your project directory:
```bash
composer require sodecl/scheduler
```

## Usage
### Basic Setup
First, ensure you import the necessary classes from the library:
```php
use Sodecl\Scheduler\Schedule;
use Sodecl\Scheduler\ScheduleConfig;
use Sodecl\Scheduler\TimeSlot;
```

### Schedule Configuration
Create a `ScheduleConfig` object to define your schedule parameters:
```php
$scheduleConfig = ScheduleConfig::make()
    ->openingHour('08:00')
    ->closingHour('17:00')
    ->lunchBreak()
    ->lunchBreakStart('12:00')
    ->lunchBreakDuration(60) // in minutes
    ->slotMinutes(60)
    ->days(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
    ->scheduleStart(now()->startOfMonth())
    ->scheduleEnd(now()->endOfMonth());
```

### Creating a Schedule
Instantiate the `Schedule` class with your configuration:
```php
$schedule = new Schedule($scheduleConfig);
```

### Generating Time Slots
Generate time slots for a specific day:
```php
$date = today(); // Carbon instance for the date
$slotsTaken = []; // Array of TimeSlot objects representing booked slots

$timeSlots = $schedule->timeSlotsFor($date, $slotsTaken);
```

## Examples
### Example 1: 1 Hour Time Blocks
This example demonstrates setting up a schedule with 1-hour blocks, excluding lunch hours:

```php
$scheduleConfig = ScheduleConfig::make()
    ->openingHour('08:00')
    ->closingHour('17:00')
    ->lunchBreak()
    ->lunchBreakStart('12:00')
    ->lunchBreakDuration(60) // in minutes
    ->slotMinutes(60)
    ->days(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
    ->scheduleStart(now()->startOfMonth())
    ->scheduleEnd(now()->endOfMonth());
```

### Example 2: 15 Minute Time Blocks
In this example, the schedule is set for 15-minute time slots without a lunch break:

```php
$scheduleConfig = ScheduleConfig::make()
    ->openingHour('08:00')
    ->closingHour('17:00')
    ->lunchBreak()
    ->lunchBreakStart('12:00')
    ->lunchBreakDuration(60) // in minutes
    ->slotMinutes(15)
    ->days(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
    ->scheduleStart(now()->startOfMonth())
    ->scheduleEnd(now()->endOfMonth());
```

## Contributing
Contributions to the Sodecl Scheduler are welcome. Please ensure to follow the project's code standards and submit your pull requests for review.

## License
MIT

---

