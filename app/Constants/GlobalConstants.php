<?php

namespace App\Constants;

class GlobalConstants
{
    //images 
    const USER_IMAGES_PATH = 'public/users';

    // Project Decimal Precision

    const DECIMAL_TOTALS = 26;
    const DECIMAL_PRECISION = 8;

    //languages
    const LANG_EN = 1; // English
    const LANG_HI = 2; // Hindi
    const LANG_TL = 3; // Pilipino 
    const LANG_VN = 4; // Vietnamese

    public static function getLanguages()
    {
        return [
            static::LANG_EN => 'English',
            static::LANG_HI => 'Hindi',
            static::LANG_TL => 'Pilipino',
            static::LANG_VN => 'Vietnamese'
        ];
    }

    public static function getLanguage($languageValue)
    {
        return static::getLanguages()[$languageValue] ?? null;
    }
}
