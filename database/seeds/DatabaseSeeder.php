<?php

use App\User;
use App\Model\Bill;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Referral;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Display foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Patient::truncate();
        Doctor::truncate();
        Referral::truncate();
        Bill::truncate();

        $usersQuantity = 4;
        $patientsQuantity = 20;
        $doctorsQuantity = 20;
        $referralsQuantity = 5;
        $billsQuantity = 30;

        factory(User::class, $usersQuantity)->create();
        factory(Patient::class, $patientsQuantity)->create();
        factory(Doctor::class, $doctorsQuantity)->create();
        factory(Referral::class, $referralsQuantity)->create();
        factory(Bill::class, $billsQuantity)->create();

    }
}
