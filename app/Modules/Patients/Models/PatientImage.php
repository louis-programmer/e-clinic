<?php
# unused ver
namespace App\Modules\Patients\Models;

use App\Modules\Patients\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientImage extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Allowed Mass Assignment
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'patient_id',
        'file_path',
        'uploaded_by',
        'type',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | Allowed Image Types
    |--------------------------------------------------------------------------
    */
    public const TYPE_PHOTO = 'photo';

    public const TYPE_XRAY = 'xray';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploader()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'uploaded_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePhotos($query)
    {
        return $query->where(
            'type',
            self::TYPE_PHOTO
        );
    }

    public function scopeXrays($query)
    {
        return $query->where(
            'type',
            self::TYPE_XRAY
        );
    }
}