<?php

namespace Paradox\NepaliDate\Data;

class NepaliMonth
{
    public static function name(int $month): string
    {
        return match ($month) {
            1 => 'बैशाख',
            2 => 'जेठ',
            3 => 'असार',
            4 => 'श्रावण',
            5 => 'भाद्र',
            6 => 'आश्विन',
            7 => 'कार्तिक',
            8 => 'मंसिर',
            9 => 'पौष',
            10 => 'माघ',
            11 => 'फाल्गुण',
            12 => 'चैत्र',
            default => '',
        };
    }
}
