<?php

namespace App\Constants;

class JobPostConstants
{
    const TABLE_NAME = 'job_posts';

    const PAYMENT_TYPE_HOURLY = 1;
    const PAYMENT_TYPE_FIXED = 2;

    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_HOURLY => 'Hourly',
            self::PAYMENT_TYPE_FIXED => 'Fixed',
        ];
    }

    public static function getPaymentType($paymentTypeValue)
    {
        return static::getPaymentTypes()[$paymentTypeValue] ?? null;
    }

    const STATUS_CLOSED = 1;
    const STATUS_OPENED = 2;

    public static function getStatuses()
    {
        return [
            self::STATUS_CLOSED => 'CLOSED',
            self::STATUS_OPENED => 'OPENED',
        ];
    }

    public static function getStatus($statusValue)
    {
        return static::getStatuses()[$statusValue] ?? null;
    }
}
