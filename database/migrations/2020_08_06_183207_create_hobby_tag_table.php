<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHobbyTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobby_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('hobby_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->timestamps();
            
            //Definition neuer Primärschlüssel - dadurch kann eine Kombination von hobby und tag nur einmal erfolgen!
            $table->primary('hobby_id', 'tag_id');
            
            // Foreign Key Contstraints = Verbindung zu Fremdschlüssel
            // onDelete = wenn die Fremdschlüssel gelöscht werden!
            $table->foreign('hobby_id')
                    ->references('id')->on('hobbies')
                    ->onDelete('cascade');
            $table->foreign('tag_id')
                    ->references('id')->on('tags')
                    ->onDelete('cascade');            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby_tag');
    }
}
