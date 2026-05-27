<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use App\Modules\Patients\Models\Patient;
use App\Models\InvoiceItem;

class Invoice extends Model
{
protected $fillable = [
    'patient_id',
    'invoice_number',

    'subtotal',

    'discount_amount',
    'discount_type',
    'discount_value',

    'total',
    'paid_amount',
    'balance',
    'status',
    'remarks',
    'created_by',
];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
        {
            return $this->hasMany(Payment::class);
        }



        public function patient()
        {
            return $this->belongsTo(Patient::class);
        }


    


}