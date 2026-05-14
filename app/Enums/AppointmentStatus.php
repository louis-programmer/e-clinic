<?php
# update May 14

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

    /*
    |--------------------------------------------------------------------------
    | Final States
    |--------------------------------------------------------------------------
    */
    public static function final(): array
    {
        return [
            self::COMPLETED,
            self::CANCELLED,
            self::NO_SHOW,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Labels
    |--------------------------------------------------------------------------
    */
    public static function labels(): array
    {
        return [
            self::SCHEDULED   => 'Scheduled',
            self::RESCHEDULED => 'Rescheduled',
            self::COMPLETED   => 'Completed',
            self::CANCELLED   => 'Cancelled',
            self::NO_SHOW     => 'No Show',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    */
    public static function colors(): array
    {
        return [
            self::SCHEDULED   => '#2563eb',
            self::RESCHEDULED => '#7c3aed',
            self::COMPLETED   => '#16a34a',
            self::CANCELLED   => '#dc2626',
            self::NO_SHOW     => '#ea580c',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */
    public static function label(string $status): string
    {
        return self::labels()[$status] ?? ucfirst($status);
    }

    public static function color(string $status): string
    {
        return self::colors()[$status] ?? '#64748b';
    }
}