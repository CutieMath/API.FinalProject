<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    private $patient;
    private $item_numbers;
    private $attendant_doctor;
    private $referral;

    private $date_of_service;
    private $location_of_service;
    private $notes;
    private $status;


    public function __construct($patient, $item_numbers, $attendant_doctor, $referral, $date_of_service, $location_of_service, $notes, $status)
    {
        $this->patient = $patient;
        $this->item_numbers = $item_numbers;
        $this->attendant_doctor = $attendant_doctor;
        $this->referral = $referral;

        $this->date_of_service = $date_of_service;
        $this->location_of_service = $location_of_service;
        $this->notes = $notes;
        $this->status = $status;
    
    }
}
