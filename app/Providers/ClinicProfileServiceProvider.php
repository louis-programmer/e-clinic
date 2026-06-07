<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ClinicProfile;

class ClinicProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {

            $clinicProfile = ClinicProfile::first();

            $view->with(
                'clinicProfile',
                $clinicProfile
            );

        });
    }
}