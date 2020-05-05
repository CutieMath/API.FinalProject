<?php

namespace App\Model;

use App\Model\Doctor;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    // Create referral object
    // private $doctor;
    // private $length;
    // private $date;

    // public function __construct($doctor, $length, $date)
    // {
    //     $this->doctor = $doctor;
    //     $this->length = $length;
    //     $this->date = $date;
    // }


    protected $fillable = [
        'doctor_id', 
        'length',
        'date',
    ];

    public function doctor(){
        return $this->hasOne(Doctor::class);
    }


}
