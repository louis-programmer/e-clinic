<?php

return [

    'scan_access' => ['admin', 'staff'],

    'patient_manage' => ['admin'], // appointments
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
    
	/// Currently "Progress Notes " 
    'encounter_view' => ['admin', 'staff', 'doctor'],
    'encounter_manage' => ['admin', 'staff'],
    'encounter_delete' => ['admin'],

];
