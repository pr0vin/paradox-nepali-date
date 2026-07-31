<?php

namespace Paradox\NepaliDate\Data;

class NepaliWeekDay
{
    public static function name(int $day): string
    {
        return match ($day) {
            0 => 'आइतबार',
            1 => 'सोमबार',
            2 => 'मंगलबार',
            3 => 'बुधबार',
            4 => 'बिहिबार',
            5 => 'शुक्रबार',
            6 => 'शनिबार',
            default => '',
        };
    }


    public static function short(int $day): string
    {
        return match ($day) {
            0 => 'आइत',
            1 => 'सोम',
            2 => 'मंगल',
            3 => 'बुध',
            4 => 'बिहि',
            5 => 'शुक्र',
            6 => 'शनि',
            default => '',
        };
    }
}
