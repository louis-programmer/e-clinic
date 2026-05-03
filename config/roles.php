<?php

return [

    'scan_access' => ['admin', 'staff'],

    'patient_view' => ['admin', 'staff', 'doctor'],
    'patient_manage' => ['admin'],

    'encounter_view' => ['admin', 'staff', 'doctor'],
    'encounter_manage' => ['admin', 'staff'],
    'encounter_delete' => ['admin'],

];