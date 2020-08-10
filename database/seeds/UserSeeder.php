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
        factory(App\User::class, 100)->create()
        ->each(function ($user){ // Für jeden User 1-7 Hobbies
            factory(App\Hobby::class,rand(1,8))->create(
                [
                    'user_id' => $user->id
                ]
            );           
        });
        /*
        ->​ each​ (function ($hobby){ // Für jedes Hobby 1-8 unterschiedl. Tags
        $tag_ids = range(1,8);
        shuffle($tag_ids);
        $verknuepfungen = array_slice($tag_ids, 0, rand(0,8));
        foreach ($verknuepfungen as $value) {
        DB::table('hobby_tag')
        ->insert([
        'hobby_id' => $hobby->id,
        'tag_id' => $value,
        'created_at' => Now(),
        'updated_at' => Now(),
        }
        */
    }
}
