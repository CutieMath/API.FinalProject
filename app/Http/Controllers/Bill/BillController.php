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
        $patientData = $request->input('patient');
        Patient::create($patientData);
 
        // Find the attendant doctor id based on the request


        // Find the referral doctor id based on the request


        // Insert required data into claim table 
        Bill::create([
            'patient_id' => $request->input('patient.first_name'),
            'doctor_id' => $request->input('attendant_doctor.first_name'),
            'referral_id' => $request->input('referral.doctor.first_name'),
            'item_numbers' => $request->input('item_numbers'), 
            'date_of_service' => $request->input('date_of_service'),
            'location_of_service' => $request->input('location_of_service'),
            'notes' => $request-> input('notes'),
            'status' => $request-> input('status'),
        ]);


        $response['message'] = $this->uploadClaimSuccess;   
        return $this->showSuccess($response);     

    }

    public function find(Request $request, Doctor $doctor)
    {
        $doctor = $request->input('attendant_doctor');

        // Search for a doctor based on their title + first name + last name
        if($request->has('attendant_doctor.title')){
            $doctor->where('title', $request->input('doctor.title'));
        }
        if($request->has('attendant_doctor.first_name')){
            $doctor->where('first_name', $request->input('doctor.first_name'));
        }
        if($request->has('attendant_doctor.last_name')){
            $doctor->where('last_name', $request->input('doctor.last_name'));
        }
        return $doctor->get();
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
