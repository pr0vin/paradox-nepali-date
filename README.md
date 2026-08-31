# Paradox Nepali Date

A Laravel-friendly **Bikram Sambat (BS)** date package for converting, formatting, and manipulating Nepali dates.

Built with [Carbon](https://carbon.nesbot.com/) compatibility and a simple, developer-friendly API.

## Features

- AD ↔ BS date conversion
- Create BS dates
- Get today's Nepali date
- Nepali month names
- Nepali weekday names
- Date formatting
- Human-readable dates
- Carbon conversion
- Date arithmetic
- Date comparison
- Difference between dates
- JSON serialization
- Helper functions
- Laravel service container integration
- PSR-4 autoloading

---

# Requirements

- PHP `^8.2`
- Laravel `11.x` or `12.x`
- Carbon `^3.0`

---

# Installation

Install the package via Composer:

```bash
composer require paradox/nepali-date
```

The Laravel service provider is automatically registered through Laravel package discovery.

---

# Usage

## Import

```php
use Paradox\NepaliDate\NepaliDate;
```

You can resolve the package through Laravel's service container:

```php
$nepaliDate = app(NepaliDate::class);
```

Alternatively, use dependency injection:

```php
use Paradox\NepaliDate\NepaliDate;

class ExampleController
{
    public function index(NepaliDate $nepaliDate)
    {
        //
    }
}
```

Dependency injection is recommended when using the package inside controllers, services, jobs, and other Laravel classes.

---

# Convert AD to BS

```php
$nepaliDate = app(NepaliDate::class);

$date = $nepaliDate->parse('2026-07-31');

echo $date->format();
// 2083-04-15

echo $date->readable();
// 15 श्रावण 2083
```

You can also use:

```php
$date = $nepaliDate->adToBs('2026-07-31');
```

---

# Create a BS Date

```php
$nepaliDate = app(NepaliDate::class);

$date = $nepaliDate->create(
    2083,
    4,
    15
);

echo $date->format();

// 2083-04-15
```

The arguments are:

```text
year, month, day
```

For example:

```php
$nepaliDate->create(2083, 4, 15);
```

creates:

```text
2083-04-15
```

---

# Get Today's Nepali Date

```php
$nepaliDate = app(NepaliDate::class);

$date = $nepaliDate->today();

echo $date->format();
```

You can also use:

```php
$date = $nepaliDate->now();
```

### `today()` vs `now()`

Both return the current Nepali date.

```php
$nepaliDate->today();
$nepaliDate->now();
```

---

# Access Date Components

```php
$nepaliDate = app(NepaliDate::class);

$date = $nepaliDate->parse('2026-07-31');

echo $date->year();
// 2083

echo $date->month();
// 4

echo $date->day();
// 15
```

---

# Nepali Month Name

```php
echo $date->monthName();

// श्रावण
```

You can also retrieve a month name directly:

```php
echo $nepaliDate->monthName(4);

// श्रावण
```

---

# Weekday

Get the full Nepali weekday name:

```php
echo $date->weekName();

// शुक्रबार
```

You can also retrieve a weekday directly:

```php
echo $nepaliDate->weekName(6);
```

---

# Short Weekday

```php
echo $date->shortWeek();

// शुक्र
```

Or:

```php
echo $nepaliDate->shortWeek(6);
```

---

# Day of Week

The package provides both standard and ISO weekday numbers.

```php
$date->dayOfWeek();
```

Returns:

```text
0 - 6
```

ISO weekday:

```php
$date->dayOfWeekIso();
```

Returns:

```text
1 - 7
```

---

# Date Formatting

The default format is:

```php
echo $date->format();

// 2083-04-15
```

You can specify a custom separator:

```php
echo $date->format('/');

// 2083/04/15
```

---

# Human-Readable Date

```php
echo $date->readable();

// 15 श्रावण 2083
```

---

# Convert BS to AD

Create a BS date:

```php
$nepaliDate = app(NepaliDate::class);

$date = $nepaliDate->create(
    2083,
    4,
    15
);
```

Convert it to Carbon:

```php
$carbon = $date->toCarbon();

echo $carbon->format('Y-m-d');

// 2026-07-31
```

You can also use the converter directly through the main API:

```php
$englishDate = $nepaliDate->bsToAd(
    2083,
    4,
    15
);
```

---

# Convert to Carbon

Every `NepaliDate` object can be converted to Carbon:

```php
$date = $nepaliDate->create(
    2083,
    4,
    15
);

$carbon = $date->toCarbon();
```

You can then use Carbon functionality:

```php
echo $carbon->format('Y-m-d');
```

Result:

```text
2026-07-31
```

---

# Convert to Array

```php
$array = $date->toArray();
```

Example:

```php
[
    'year' => 2083,
    'month' => 4,
    'day' => 15,
    'formatted' => '2083-04-15',
    'readable' => '15 श्रावण 2083',
    'month_name' => 'श्रावण',
    'week_name' => 'शुक्रबार',
    'short_week' => 'शुक्र',
    'ad_date' => '2026-07-31',
]
```

---

# JSON Serialization

`NepaliDate` implements `JsonSerializable`.

Therefore, you can use:

```php
return response()->json($date);
```

Or:

```php
$json = json_encode($date);
```

The resulting JSON contains the date information:

```json
{
  "year": 2083,
  "month": 4,
  "day": 15,
  "formatted": "2083-04-15",
  "readable": "15 श्रावण 2083",
  "month_name": "श्रावण",
  "week_name": "शुक्रबार",
  "short_week": "शुक्र",
  "ad_date": "2026-07-31"
}
```

---

# Date Manipulation

## Add Days

```php
$newDate = $date->addDays(10);
```

## Subtract Days

```php
$newDate = $date->subDays(5);
```

## Add One Day

```php
$newDate = $date->addDay();
```

## Subtract One Day

```php
$newDate = $date->subDay();
```

---

## Add Months

```php
$newDate = $date->addMonths(2);
```

## Subtract Months

```php
$newDate = $date->subMonths(1);
```

## Add One Month

```php
$newDate = $date->addMonth();
```

## Subtract One Month

```php
$newDate = $date->subMonth();
```

---

## Add Years

```php
$newDate = $date->addYears(1);
```

## Subtract Years

```php
$newDate = $date->subYears(1);
```

## Add One Year

```php
$newDate = $date->addYear();
```

## Subtract One Year

```php
$newDate = $date->subYear();
```

---

# Date Comparison

## Equals

```php
$date1 = $nepaliDate->create(
    2083,
    4,
    15
);

$date2 = $nepaliDate->create(
    2083,
    4,
    15
);

$date1->equals($date2);

// true
```

---

## Before

```php
$date1->isBefore($date2);

// true / false
```

---

## After

```php
$date1->isAfter($date2);

// true / false
```

---

## Between

```php
$date = $nepaliDate->create(
    2083,
    4,
    15
);

$start = $nepaliDate->create(
    2083,
    4,
    1
);

$end = $nepaliDate->create(
    2083,
    4,
    30
);

$date->between(
    $start,
    $end
);

// true
```

You can also control whether the boundaries are inclusive:

```php
$date->between(
    $start,
    $end,
    false
);
```

---

# Difference in Days

```php
$date1 = $nepaliDate->create(
    2083,
    4,
    15
);

$date2 = $nepaliDate->create(
    2083,
    4,
    20
);

$difference = $date1->diffInDays($date2);

// 5
```

---

# Helper Functions

The package also provides helper functions when the helper file is loaded.

## AD to BS

```php
ad_to_bs('2026-07-31');
```

## BS to AD

```php
bs_to_ad(
    2083,
    4,
    15
);
```

## Nepali Month

```php
nepali_month(4);
```

## Nepali Weekday

```php
nepali_week(6);
```

## Short Nepali Weekday

```php
nepali_short_week(6);
```

---

# Complete Example

```php
use Paradox\NepaliDate\NepaliDate;

class ExampleController
{
    public function index(NepaliDate $nepaliDate)
    {
        $date = $nepaliDate->parse(
            '2026-07-31'
        );

        echo $date->format();
        // 2083-04-15

        echo $date->monthName();
        // श्रावण

        echo $date->weekName();
        // शुक्रबार

        echo $date->readable();
        // 15 श्रावण 2083

        echo $date
            ->toCarbon()
            ->format('Y-m-d');

        // 2026-07-31
    }
}
```

---

# Laravel Service Container

The package registers `NepaliDate` with Laravel's service container.

You can resolve it manually:

```php
$nepaliDate = app(
    \Paradox\NepaliDate\NepaliDate::class
);
```

Or inject it into your class:

```php
use Paradox\NepaliDate\NepaliDate;

public function index(NepaliDate $nepaliDate)
{
    $date = $nepaliDate->today();

    return $date->format();
}
```

---

# Testing

The package includes PHPUnit tests.

Run the test suite from the package root:

```bash
vendor/bin/phpunit
```

On Windows PowerShell:

```powershell
.\vendor\bin\phpunit
```

---

# License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
