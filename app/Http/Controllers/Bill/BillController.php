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
            'referral.date' => 'required|date_format:d/m/Y',

            'date_of_service' => 'required|date_format:d/m/Y',
            'location_of_service' => 'required',
            
            // Notes and status can be empty
            //'notes' => 'required',
            //'status' => 'required',
        ];
        


        // Validate the request
        $this->validate($request, $rules);

        // insert into patient table
        //$patientData = $request->input('patient');
        //Patient::create($patientData);

        // Find the doctor based on the request
        //$doctorData = $request->input('attendant_doctor');
        //Doctor::create($doctorData);

        // insert into referral table
        //$referralDoctorData = $request->input('referral.doctor');
        //Doctor::create($referralDoctorData);

        //$data = $request->input('referral');
        //Referral::create($data);


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
