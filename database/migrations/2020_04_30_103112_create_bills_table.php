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
            
            $table->string('item_numbers');
            
            //Foreign Key (doctors)
            $table->bigInteger('doctor_id')->unsigned();
            
            // Foreign Key (Referrals)
            $table->bigInteger('referral_id')->unsigned();

            $table->string('date_of_service');
            $table->string('location_of_service');
            $table->string('notes')->nullable();
            $table->string('status')->nullable();
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
