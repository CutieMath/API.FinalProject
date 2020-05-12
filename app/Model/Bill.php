<?php

namespace App\Model;

use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Referral;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'referral_id',
        'item_numbers',
        'date_of_service',
        'location_of_service',
        'notes',
        'status',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }

}
