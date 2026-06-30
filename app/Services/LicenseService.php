<?php

namespace App\Services;

use App\Models\License;
#use App\Models\ActivatedLicense;

class LicenseService
{
    /**
     * Currently installed license
     */
    public function current(): ?License
    {
        return License::first();
    }

    /**
     * Master license database
     */
    protected function masterLicenses(): array
    {
        return require storage_path('licensing/licenses.php');
    }


public function activate(string $activationCode): bool
{
    $master = $this->masterLicenses();

    if (!isset($master['licenses'][$activationCode])) {
        return false;
    }

    $license = $master['licenses'][$activationCode];

    /*
    |--------------------------------------------------------------------------
    | Verify clinic ID
    |--------------------------------------------------------------------------
    */

    if ((int)$license['clinic_id'] !== (int)config('clinic.id')) {
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove existing license
    |--------------------------------------------------------------------------
    */

    License::query()->delete();

    /*
    |--------------------------------------------------------------------------
    | Save activated license
    |--------------------------------------------------------------------------
    */

    License::create([

        'activation_code' => $activationCode,

        'clinic_id' => $license['clinic_id'],

        'plan' => $license['plan'],

        'expires_at' => $license['expires'],

        'grace_days' => $license['grace_days'],

        'activated_at' => now(),

    ]);

    return true;
}

public function getActiveLicense(): ?License
{
    return License::first();
}


public function isExpired(): bool
{
    $license = $this->getActiveLicense();

    if (!$license) {
        return true;
    }

    return now()->gt($license->expires_at);
}

public function daysUntilExpiry(): int
{
    $license = $this->getActiveLicense();

    if (!$license) {
        return 0;
    }

    return now()->diffInDays($license->expires_at, false);
}

public function isInGracePeriod(): bool
{
    $license = $this->getActiveLicense();

    if (!$license) {
        return false;
    }

    if (!$this->isExpired()) {
        return false;
    }

    $graceEnds = $license->expires_at->copy()->addDays($license->grace_days);

    return now()->lte($graceEnds);
}

public function currentPlan(): ?string
{
    return $this->getActiveLicense()?->plan;
}



public function isActivated(): bool
{
    return $this->getActiveLicense() !== null;
}




public function daysRemaining(): ?int
{
    $license = $this->getActiveLicense();

    if (!$license || !$license->expires_at) return null;

    return now()->diffInDays($license->expires_at, false);
}










}