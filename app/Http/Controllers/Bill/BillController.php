<?php

namespace App\Http\Controllers\Bill;

use App\Model\Bill;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

 
        // Find the attendant doctor's id from the request
        $doctorTitle = $request->input('attendant_doctor.title');
        $doctorFirstName = $request->input('attendant_doctor.first_name');
        $doctorLastName = $request->input('attendant_doctor.last_name');
        
        $doctorExist = DB::table('doctors')->where([
            ['title', '=', $doctorTitle],
            ['first_name', '=', $doctorFirstName],
            ['last_name', '=', $doctorLastName],
        ])->exists();



        // Find the referral doctor's id from the request
        // Note that all doctors are stored in 'doctors' table
        // 'referrals' table contains a foreign key with the doctor id
        $referralTitle = $request->input('referral.doctor.title');
        $referralFirstName = $request->input('referral.doctor.first_name');
        $referralLastName = $request->input('referral.doctor.last_name');

        $referralDoctorExist = DB::table('doctors')->where([
            ['title', '=', $doctorTitle],
            ['first_name', '=', $doctorFirstName],
            ['last_name', '=', $doctorLastName],
        ])->exists();
        

        if($doctorExist == true && $referralDoctorExist == true){

                // Get patient data & insert into table
                $patientData = $request->input('patient');
                Patient::create($patientData);

                // Get the id of the patient
                $patientFirstName = $request->input('patient.first_name');
                $patientLastName = $request->input('patient.last_name');
                $patientId = DB::table('patients')->where([
                    ['first_name', '=', $patientFirstName],
                    ['last_name', '=', $patientLastName],
                ])->value('id');


                // get the doctor id
                $doctorId = DB::table('doctors')->where([
                    ['title', '=', $doctorTitle],
                    ['first_name', '=', $doctorFirstName],
                    ['last_name', '=', $doctorLastName],
                ])->value('id');


                // get the doctor id for referrals 
                $referralDocId = DB::table('doctors')->where([
                    ['title', '=', $referralTitle],
                    ['first_name', '=', $referralFirstName],
                    ['last_name', '=', $referralLastName],
                ])->value('id');


                // Insert referral doctor id and required information into referral table
                // get the referral id
                Referral::create([
                    'doctor_id'=> $referralDocId,
                    'length'=> $request->input('referral.length'),
                    'date'=> $request->input('referral.date')
                ]);
                $referralId = DB::table('referrals')->where('doctor_id', $referralDocId)->value('id');


                // Insert required data into claim table 
                Bill::create([
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'referral_id' => $referralId,
                    'item_numbers' => $request->input('item_numbers'), 
                    'date_of_service' => $request->input('date_of_service'),
                    'location_of_service' => $request->input('location_of_service'),
                    'notes' => $request-> input('notes'),
                    'status' => $request-> input('status'),
                ]);

        }else{
            return $this->errorResponse("Cannot find doctor or referral doctor records in the databse. Please check spelling.", 400);
        }

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
