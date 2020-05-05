<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
           
            $table->bigIncrements('id');
            
            //Foreign Key (patients)
            $table->bigInteger('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients');
            
            $table->string('item_numbers');
            
            //Foreign Key (doctors)
            $table->bigInteger('doctor_id')->unsigned();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            
            // Foreign Key (Referrals)
            $table->bigInteger('referral_id')->unsigned();
            $table->foreign('referral_id')->references('id')->on('referrals');

            $table->string('date_of_service');
            $table->string('location_of_service');
            $table->string('notes');
            $table->string('status');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
