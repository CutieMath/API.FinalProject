<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    private $doctor;
    private $length;
    private $date;

    // protected $fillable = [
    //     $doctor,
    //     $length,
    //     $date,
    // ];


    public function __construct($doctor, $length, $date)
    {
        $this->doctor = $doctor;
        $this->length = $length;
        $this->date = $date;
    
    }
}
