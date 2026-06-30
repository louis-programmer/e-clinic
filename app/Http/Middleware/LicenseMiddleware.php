<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LicenseService;

class LicenseMiddleware
{
    protected $license;

    public function __construct(LicenseService $license)
    {
        $this->license = $license;
    }

    public function handle(Request $request, Closure $next)
    {
        // STEP 1: Not activated → redirect to activation
        if (!$this->license->isActivated()) {
            return redirect('/activate-license');
        }

        // STEP 2: Expired check
        if ($this->license->isExpired()) {

            // allow grace period (optional logic)
            if (!$this->license->isInGracePeriod()) {
                return redirect('/license-expired');
            }
        }

        // STEP 3: Everything OK → continue
        return $next($request);
    }
}