<?php
# update May 15 (safe upgrade - backward compatible)

namespace App\Enums;

class AppointmentStatus
{
    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */
    public const SCHEDULED   = 'scheduled';
    public const RESCHEDULED = 'rescheduled';
    public const COMPLETED   = 'completed';
    public const CANCELLED   = 'cancelled';
    public const NO_SHOW     = 'no_show';

    /*
    |--------------------------------------------------------------------------
    | Core Lists
    |--------------------------------------------------------------------------
    */

    /**
     * All valid statuses
     */
    public static function all(): array
    {
        return [
            self::SCHEDULED,
            self::RESCHEDULED,
            self::COMPLETED,
            self::CANCELLED,
            self::NO_SHOW,
        ];
    }

    /**
     * Active (not yet finished)
     */
    public static function active(): array
    {
        return [
            self::SCHEDULED,
            self::RESCHEDULED,
        ];
    }

    /**
     * Final states (terminal)
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
    | Validation
    |--------------------------------------------------------------------------
    */

    /**
     * Check if status is valid (safe guard)
     */
    public static function isValid(string $status): bool
    {
        return in_array($status, self::all(), true);
    }

    /*
    |--------------------------------------------------------------------------
    | Transition Rules (SAFE OPTIONAL LAYER)
    |--------------------------------------------------------------------------
    */

    /**
     * Controls allowed status transitions
     * (does NOT break existing code unless you use it)
     */
    public static function canTransition(string $from, string $to): bool
    {
        // If invalid input, reject safely
        if (!self::isValid($from) || !self::isValid($to)) {
            return false;
        }

        $map = [
            self::SCHEDULED => [
                self::RESCHEDULED,
                self::COMPLETED,
                self::CANCELLED,
                self::NO_SHOW,
            ],
            self::RESCHEDULED => [
                self::COMPLETED,
                self::CANCELLED,
                self::NO_SHOW,
            ],
            // terminal states cannot change
            self::COMPLETED => [],
            self::CANCELLED => [],
            self::NO_SHOW   => [],
        ];

        return in_array($to, $map[$from] ?? [], true);
    }

    /*
    |--------------------------------------------------------------------------
    | Safe Label / Color Helpers (BACKWARD COMPATIBLE)
    |--------------------------------------------------------------------------
    */

    public static function label(string $status): string
    {
        // safe fallback, but only after validation attempt
        return self::labels()[$status] ?? ucfirst($status);
    }

    public static function color(string $status): string
    {
        return self::colors()[$status] ?? '#64748b';
    }

    /*
    |--------------------------------------------------------------------------
    | Optional STRICT MODE (NOT ENABLED BY DEFAULT)
    |--------------------------------------------------------------------------
    */

    /**
     * Use this in debugging or strict clinic mode only
     */
    public static function strictLabel(string $status): string
    {
        if (!self::isValid($status)) {
            throw new \InvalidArgumentException("Invalid appointment status: {$status}");
        }

        return self::labels()[$status];
    }

    public static function strictColor(string $status): string
    {
        if (!self::isValid($status)) {
            throw new \InvalidArgumentException("Invalid appointment status: {$status}");
        }

        return self::colors()[$status];
    }
}