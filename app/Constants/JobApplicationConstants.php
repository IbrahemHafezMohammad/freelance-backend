<?php

namespace App\Constants;

class JobApplicationConstants
{
    const TABLE_NAME = 'job_applications';

    const STATUS_PENDING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'PENDING',
            self::STATUS_ACCEPTED => 'ACCEPTED',
            self::STATUS_REJECTED => 'REJECTED',
        ];
    }

    public static function getStatus($statusValue)
    {
        return static::getStatuses()[$statusValue] ?? null;
    }
}