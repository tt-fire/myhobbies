<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    //muss definiert werden welche Felder beschrieben werden dürfen!
    protected $fillable = ['name', 'beschreibung'];
}
