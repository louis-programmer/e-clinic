<?php

return [

    'scan_access' => ['admin', 'staff'],

    'patient_view' => ['admin', 'staff', 'doctor'], // patient page
    'patient_manage' => ['admin'], // appointments


	/// Currently "Progress Notes " 
    'encounter_view' => ['admin', 'staff', 'doctor'],
    'encounter_manage' => ['admin', 'staff'],
    'encounter_delete' => ['admin'],

];
