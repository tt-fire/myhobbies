<?php

use Illuminate\Database\Seeder;

use App\User;                         //User Model geladen!
use Illuminate\Support\Facades\Hash; // damit man das PW Hash erzeugen kann!
use Illuminate\Support\Str;         //damit der String akzeptiert wird!

class AdminSeeder extends Seeder
{

    // ERSTER Eintrag in den DatabaseSeeder!!! damit der dann auch erstellt wird bei Neumigration!

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin Nutzer anlegen!
        $admin = new User(
            [
                'name' => 'Markus',
                'email' => 'markus.g.guggi@gmail.com',
                'email_verified_at' => now(),
                'rolle' => 'admin',
                'password' => Hash::make('testing'),
                'remember_token' => Str::random(10),
            ]
        );
        $admin->save();

    }
}
