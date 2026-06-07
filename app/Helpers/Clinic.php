<?php

use App\Models\ClinicProfile;

if (!function_exists('clinic')) {

    function clinic()
    {
        return ClinicProfile::first();
    }
}