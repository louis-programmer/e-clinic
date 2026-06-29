<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clinic Instance ID
    |--------------------------------------------------------------------------
    |
    | Format:
    | YYYYMM + Client(3 digits) + Branch(2 digits) + PC(2 digits)
    |
    | Example:
    | 20260600101
    |
    */

    'id' => 20260600101,



    'images' => [

        'base_path' => 'patients',

        'photo_max_size' => 5120, // 5 MB

        'xray_max_size' => 10240, // 10 MB

    ],


    /*
    |--------------------------------------------------------------------------
    | Patient Folders
    |--------------------------------------------------------------------------
    */

    'folders' => [

        'photos' => 'photos',

        'xrays' => 'xrays',

        'forms' => 'forms',

        'signatures' => 'signatures',

    ],


];