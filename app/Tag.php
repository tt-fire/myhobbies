<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['name', 'style'];

    //Eloquent RElationship
    public function hobbies() {
        return $this->belongsToMany('App\Hobby');
    }
}
