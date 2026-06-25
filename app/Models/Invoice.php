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
    'signature_path',
    'created_by',
    'is_void',
'voided_at',
'voided_by',
'void_reason',

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

        protected $casts = [
            'is_void' => 'boolean',
            'voided_at' => 'datetime',
        ];

            


        public function canBeEdited()
        {
            return $this->payments()->count() === 0
                && !$this->is_void;
        }

        public function canBeVoided()
        {
            return !$this->is_void;
        }


        public function scopeActive($query)
        {
            return $query->where('is_void', false);
        }

/*

6. Future Improvement

Add this to Invoice.php:

public function scopeActive($query)
{
    return $query->where('is_void', false);
}

Then later you can write:

Invoice::active()

instead of:

Invoice::where('is_void', false)

throughout the project.
*/

}

