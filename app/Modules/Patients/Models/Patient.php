<?php

namespace App\Modules\Patients\Models;
use App\Models\Encounter;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Patients\Models\PatientImage;
#use App\Models\Appointment;
use App\Modules\Patients\Models\Appointment;
use App\Modules\Patients\Models\ProgressNote;
use App\Models\Invoice;
use App\Modules\Patients\Models\DentalChartRecord;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'clinic_id',
        'patient_code',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'gender',
        'contact_number',
        'email',
        'address',
        'occupation',
        'tags',
        'legacy_id',
        'is_legacy',
        'civil_status',


    ];


    protected $casts = [
        'birthdate' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
        
    }

    public function getAgeAttribute()
    {
        return $this->birthdate
            ? $this->birthdate->age
            : null;
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }


        public function images()
        {
            return $this->hasMany(PatientImage::class);
        }


        public function appointments()
        {
            return $this->hasMany(Appointment::class)
                ->orderBy('appointment_date', 'desc');
        }


        public function forms()
        {
            return $this->hasMany(\App\Modules\Forms\Models\PatientForm::class);
        }

        public function medicalHistories()
        {
            return $this->hasMany(\App\Modules\Patients\Models\MedicalHistory::class)
                ->latest();
        }


        public function progressNotes()
        {
            return $this->hasMany(\App\Modules\Patients\Models\ProgressNote::class);
        }

        public function invoices()
        {
            return $this->hasMany(Invoice::class);
        }

        public function getTotalBalanceAttribute()
        {
                return $this->invoices()
                    ->where('is_void', false)
                    ->sum('balance');
        }

        public function dentalChartRecords()
        {
            return $this->hasMany(\App\Models\DentalChartRecord::class);
        }




            public function lastVisitDate()
            {
                $lastEncounter = $this->encounters
                    ->sortByDesc('encounter_date')
                    ->first()?->encounter_date;

                $lastInvoice = $this->invoices
                    ->sortByDesc('created_at')
                    ->first()?->created_at;

                return collect([$lastEncounter, $lastInvoice])
                    ->filter()
                    ->sortDesc()
                    ->first();
            }

}