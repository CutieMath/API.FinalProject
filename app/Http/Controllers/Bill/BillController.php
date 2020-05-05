<?php

namespace App\Http\Controllers\Bill;

use App\Model\Bill;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Referral;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BillController extends ApiController
{

    public $successStatus = 200;
    public $uploadClaimSuccess = "Successfully uploaded to Genie!";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $claims = Bill::all();  
        return response()->json(['data' => $claims], $successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Creating validation rules for json request
        $rules = [
            'patient.title' => 'required',
            'patient.first_name' => 'required',
            'patient.last_name' => 'required',
            
            'item_numbers' => 'required',
            
            'attendant_doctor.title' => 'required',
            'attendant_doctor.first_name' => 'required',
            'attendant_doctor.last_name' => 'required',
            
            'referral.doctor.title' => 'required',
            'referral.doctor.first_name' => 'required',
            'referral.doctor.last_name' => 'required',
            'referral.length' => 'required',
            'referral.date' => 'required',

            'date_of_service' => 'required',
            'location_of_service' => 'required',
            
            // Notes and status can be empty
            //'notes' => 'required',
            //'status' => 'required',
        ];
        

        // Validate the request
        $this->validate($request, $rules);
        
        
        $data = $request->all();
        
        // Creating patient object from the request
        $patient = new Patient($data['patient']['title'], $data['patient']['first_name'], $data['patient']['last_name']);

        // Createing doctor object from the request
        $attendant_doctor = new Doctor($data['attendant_doctor']['title'], $data['attendant_doctor']['first_name'], $data['attendant_doctor']['last_name']);

        // Creating referral doctor object from the request
        $referral_doctor = new Doctor($data['referral']['doctor']['title'], $data['referral']['doctor']['first_name'], $data['referral']['doctor']['last_name']);

        // Creating referral object from the request
        $referral = new Referral($referral_doctor, $data['referral']['length'], $data['referral']['date']);

        // Create bill object object from the request
        $bill = new Bill($patient, $data['item_numbers'], $attendant_doctor, $referral, $data['date_of_service'], $data['location_of_service'], $data['notes'], $data['status']);    

        // Store the Claim object to Genie
        // To be implemented after connecting to Genie database


        
        
        $response['message'] = $this->uploadClaimSuccess;   
        return $this->showSuccess($response);     

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::findOrFail($id);
        return response()->json(['data' => $bill], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill -> delete();
        return $this->showOne($bill);
    }
}
