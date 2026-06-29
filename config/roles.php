<?php

return [

    'scan_access' => ['admin', 'staff'],

    'patient_manage' => ['admin'], // appointments , editing 
    'patient_view' => ['admin', 'staff', 'doctor'], // patient page
    'progress_notes' => ['admin', 'staff', 'doctor'], // Progress/Patient notes
    'overview_history' => ['admin', 'staff', 'doctor'], // Progress/Patient notes
    'patient_photos' => ['admin', 'staff', 'doctor'], // Photos
    
    /// Invoice and payment
   
   /* 
    'invoice_view' => ['admin', 'staff', 'doctor'],
	'invoice_create' => ['admin', 'staff'],
	'invoice_update' => ['admin'],
	'invoice_delete' => ['admin'],
    
    */

    /*


|--------------------------------------------------------------------------
| Patient View Tabs
|--------------------------------------------------------------------------
*/

'appointments'      => ['admin', 'staff', 'doctor'],

'overview_history'  => ['admin', 'staff', 'doctor'],

'progress_notes'    => ['admin', 'staff', 'doctor'],

'patient_photos'    => ['admin', 'staff', 'doctor'],

'patient_xrays'     => ['admin', 'staff', 'doctor'],

'patient_forms'     => ['admin', 'staff', 'doctor'],

'dental_diagram'    => ['admin', 'staff', 'doctor'],




    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    'dashboard_statistics' => ['admin', 'staff', 'doctor'], // general dashboard

    'dashboard_financial' => ['admin'],

   'dashboard_reports' => ['admin'],


    
	/// Currently "Progress Notes " 
    'encounter_view' => ['admin', 'staff', 'doctor'],
    'encounter_manage' => ['admin', 'staff'],
    'encounter_delete' => ['admin'],



    //// clinic settings
    #'clinic_profile_view' => ['admin', 'staff'],

    'clinic_profile_manage' => ['admin'],

    #'clinic_payment_settings' => ['admin'],


    'user_manage' => ['admin'],

];
