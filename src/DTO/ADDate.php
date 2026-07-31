<?php

namespace Paradox\NepaliDate\DTO;

class ADDate
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    ) {}
}
