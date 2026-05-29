<?php

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class PatientImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'file_path',
        'uploaded_by',
        'type',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // =====================================================
    // SCOPES
    // =====================================================

    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    public function scopeXrays($query)
    {
        return $query->where('type', 'xray');
    }
}