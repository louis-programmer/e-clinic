<?php

namespace App\Enums;

class AppointmentStatus
{
    public const SCHEDULED   = 'scheduled';
    public const RESCHEDULED = 'rescheduled';
    public const COMPLETED   = 'completed';
    public const CANCELLED   = 'cancelled';
    public const NO_SHOW     = 'no_show';

    public static function active(): array
    {
        return [
            self::SCHEDULED,
            self::RESCHEDULED,
        ];
    }

    public static function final(): array
    {
        return [
            self::COMPLETED,
            self::CANCELLED,
            self::NO_SHOW,
        ];
    }
}