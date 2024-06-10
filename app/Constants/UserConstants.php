<?php

namespace App\Constants;

class UserConstants
{
    const TABLE_NAME = 'users';

    //gender
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_UNKNOWN = 3;

    public static function getGenders()
    {
        return [
            static::GENDER_MALE => 'male',
            static::GENDER_FEMALE => 'female',
            static::GENDER_UNKNOWN => 'unknown'
        ];
    }

    public static function getGender($genderValue)
    {
        return static::getGenders()[$genderValue] ?? null;
    }
}