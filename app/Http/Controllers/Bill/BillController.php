<?php

namespace App\Http\Controllers\Bill;

use App\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::all();
        
        return response()->json(['data' => $bills], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'item_numbers' => 'required',
            'attendant_doctor' => 'required',
            'referral' => 'required',
            'date_of_service' => 'required',
            'location_of_service' => 'required',
            'status' => 'required',
        ];

        $this -> validate($request, $rules);

        $newBill = Bill::create($request->all());
        
        return response()->json(['success'=>$success], $this->showOne($newBill, 201));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        return $this->showOne($bill);
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
