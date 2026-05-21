<?php

namespace App\Models;
use App\Modules\Patients\Models\Procedure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'procedure_id',
        'description',
        'qty',
        'unit_price',
        'line_total',
    ];

        public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}