# Paradox Nepali Date

A Laravel-friendly Bikram Sambat (BS) date package for converting, formatting, and manipulating Nepali dates.

Built with Carbon compatibility and a simple developer-friendly API.

## Features

- AD ↔ BS conversion
- Create BS dates
- Today's Nepali date
- Nepali month and weekday names
- Date formatting
- Human readable dates
- Carbon conversion
- Date arithmetic
- Date comparison
- JSON serialization
- Helper functions

---

# Installation

Install via Composer:

```bash
composer require paradox/nepali-date
```

---

# Usage

## Import

```php
use Paradox\NepaliDate\NepaliDate;
```

---

# Convert AD to BS

```php
$date = NepaliDate::parse('2026-07-31');

echo $date->format();
// 2083-04-15

echo $date->readable();
// 15 श्रावण 2083
```

---

# Create a BS Date

```php
$date = NepaliDate::create(
    2083,
    4,
    15
);

echo $date->format();

// 2083-04-15
```

---

# Get Today's Nepali Date

```php
$date = NepaliDate::today();

echo $date->format();
```

or

```php
$date = NepaliDate::now();
```

---

# Access Date Components

```php
$date = NepaliDate::parse('2026-07-31');

$date->year();
// 2083

$date->month();
// 4

$date->day();
// 15
```

---

# Nepali Month Name

```php
$date->monthName();

// श्रावण
```

---

# Week Day

```php
$date->weekName();

// शुक्रबार
```

---

# Short Week Day

```php
$date->shortWeek();

// शुक्र
```

---

# Date Formatting

Default format:

```php
$date->format();

// 2083-04-15
```

Custom separator:

```php
$date->format('/');

// 2083/04/15
```

---

# Human Readable Format

```php
$date->readable();

// 15 श्रावण 2083
```

---

# Convert BS to AD

```php
$date = NepaliDate::create(
    2083,
    4,
    15
);

echo $date
    ->toCarbon()
    ->format('Y-m-d');

// 2026-07-31
```

---

# Convert to Array

```php
$date->toArray();
```

Example:

```php
[
    "year" => 2083,
    "month" => 4,
    "day" => 15,
    "formatted" => "2083-04-15",
    "readable" => "15 श्रावण 2083",
    "month_name" => "श्रावण",
    "week_name" => "शुक्रबार",
    "short_week" => "शुक्र",
    "ad_date" => "2026-07-31"
]
```

---

# Date Manipulation

## Add Days

```php
$date->addDays(10);
```

## Subtract Days

```php
$date->subDays(5);
```

## Add Months

```php
$date->addMonths(2);
```

## Subtract Months

```php
$date->subMonths(1);
```

## Add Years

```php
$date->addYears(1);
```

## Subtract Years

```php
$date->subYears(1);
```

---

# Date Comparison

## Equals

```php
$date1 = NepaliDate::create(2083,4,15);

$date2 = NepaliDate::create(2083,4,15);

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
$date->between(
    NepaliDate::create(2083,4,1),
    NepaliDate::create(2083,4,30)
);

// true
```

---

## Difference In Days

```php
$date1 = NepaliDate::create(2083,4,15);

$date2 = NepaliDate::create(2083,4,20);


$date1->diffInDays($date2);

// 5
```

---

# Carbon Support

Convert Nepali date to Carbon:

```php
$date = NepaliDate::create(
    2083,
    4,
    15
);

$carbon = $date->toCarbon();

echo $carbon->format('Y-m-d');

// 2026-07-31
```

---

# Helper Functions

If helpers are enabled:

```php
ad_to_bs('2026-07-31');

bs_to_ad(
    2083,
    4,
    15
);

nepali_month(4);

nepali_week(6);

nepali_short_week(6);
```

---

# Complete Example

```php
use Paradox\NepaliDate\NepaliDate;


$date = NepaliDate::parse(
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
```

---

# License

MIT License
