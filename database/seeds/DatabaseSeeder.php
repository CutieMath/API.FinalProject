<?php

use App\Bill;
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
        //User::truncate();
        Bill::truncate();
        $billsQuantity = 50;

        factory(Bill::class, $billsQuantity)->create();
    }
}
