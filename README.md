# Usage

## Import

```php
use Paradox\NepaliDate\NepaliDate;
```

---

## Convert AD to BS

```php
$date = NepaliDate::parse('2026-07-31');

echo $date->format();      // 2083-04-15
echo $date->readable();    // 15 श्रावण 2083
```

---

## Create a BS Date

```php
$date = NepaliDate::bs(2083, 4, 15);

echo $date->format();      // 2083-04-15
```

---

## Get Today's Nepali Date

```php
$date = NepaliDate::today();

echo $date->format();
```

or

```php
$date = NepaliDate::now();
```

---

## Access Date Components

```php
$date = NepaliDate::parse('2026-07-31');

$date->year();        // 2083
$date->month();       // 4
$date->day();         // 15
```

---

## Nepali Month Name

```php
$date->monthName();

// Output:
// श्रावण
```

---

## Week Day

```php
$date->weekName();

// Output:
// शुक्रबार
```

---

## Short Week Day

```php
$date->shortWeek();

// Output:
// शुक्र
```

---

## Format Nepali Date

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

## Human Readable Format

```php
$date->readable();

// 15 श्रावण 2083
```

---

## Convert BS to AD

```php
$date = NepaliDate::bs(2083, 4, 15);

echo $date->toCarbon()->format('Y-m-d');

// 2026-07-31
```

---

## Convert to Array

```php
$date->toArray();
```

Example output:

```php
[
    "year" => 2083,
    "month" => 4,
    "day" => 15,
    "month_name" => "श्रावण",
    "week_name" => "शुक्रबार",
    "short_week" => "शुक्र",
]
```

---

## Helper Functions

If helper functions are enabled, you can use:

```php
ad_to_bs('2026-07-31');

bs_to_ad(2083, 4, 15);

nepali_month(4);

nepali_week(6);

nepali_short_week(6);
```

---

## Example

```php
use Paradox\NepaliDate\NepaliDate;

$date = NepaliDate::parse('2026-07-31');

echo $date->format();        // 2083-04-15
echo $date->monthName();     // श्रावण
echo $date->weekName();      // शुक्रबार
echo $date->readable();      // 15 श्रावण 2083

$adDate = $date->toCarbon()->format('Y-m-d');

echo $adDate;                // 2026-07-31
```
