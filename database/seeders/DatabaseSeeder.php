<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\Meals;
use App\Models\Tables;
use App\Models\Waiters;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

        Meals::factory(10)->create();
        Customers::factory(10)->create();
        Tables::factory(10)->create();
        Waiters::factory(10)->create();
    }
}
