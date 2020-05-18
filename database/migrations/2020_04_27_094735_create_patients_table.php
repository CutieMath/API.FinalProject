<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('Middle')->nullable();
            $table->string('DOB')->nullable();
            $table->string('Chart No')->nullable();
            $table->string('Mobile Phone')->nullable();
            $table->string('Usual Provider')->nullable();
            $table->string('Last Seen')->nullable();
            $table->string('Last Seen By')->nullable();
            $table->string('Acct Id')->nullable();
            $table->integer('Balance')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
