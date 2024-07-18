<?php

namespace App\Constants;

class GlobalConstants
{
    // Project Decimal Precision

    const DECIMAL_TOTALS = 26;
    const DECIMAL_PRECISION = 8;

    //languages
    const LANG_EN = 1;
    const LANG_AR = 2;

    public static function getLanguages()
    {
        return [
            static::LANG_EN => 'English',
            static::LANG_AR => 'Arabic',
        ];
    }

    public static function getLanguage($languageValue)
    {
        return static::getLanguages()[$languageValue] ?? null;
    }
}
