<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id',
        'invoice_number',
        'subtotal',
        'total',
        'paid_amount',
        'balance',
        'status',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}