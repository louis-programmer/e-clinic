<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicProfile extends Model
{
            protected $fillable = [
                'clinic_name',
                'logo_path',

                'contact_number',
                'email',
                'address',

                'payment_methods',

                'gcash_qr_path',
                'maya_qr_path',

                'bank_name',
                'bank_account_name',
                'bank_account_number',

                'enabled_payment_methods',
            ];

    protected $casts = [
        'payment_methods' => 'array',
        'enabled_payment_methods' => 'array',
        
    ];
}