<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    //muss definiert werden welche Felder beschrieben werden dürfen!
    protected $fillable = ['name', 'beschreibung'];

    //Eloquent - Relationships!
    //funktion im Singular, da nur ein User erwartet wird!
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
