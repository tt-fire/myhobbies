<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Aufruf der FAktory für 100 zufalls user!
        factory(App\User::class, 100)->create();
    }
}
