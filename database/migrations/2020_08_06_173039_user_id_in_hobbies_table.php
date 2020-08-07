<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserIdInHobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            //
            $table->foreignId('user_id')->nullable()->after('id'); //muss unsignedBigInteger sein weil von laravel id immer so ist!
            $table->foreign('user_id')
            ->references('id')->on('users') //auf welches Feld er sich in der anderen TAbelle bezieht!
            ->constrained()
            ->onDelete('cascade'); //legt fest wenn ein user gelöscht wird dann auch das Hobby!
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            //Gegenteil der Up FUnktion! in umgekehrter Reihenfolge!
            $table->dropForeign(['user_id']); // Muss zuerst gemacht werden
            $table->dropColumn('user_id');
        });
    }
}
