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

    //für Filtern nach Tags! neue Beziehung für das Filtern!
    public function filteredHobbies() {
        return $this->belongsToMany('App\Hobby')
            ->wherePivot('tag_id', $this->id) 
            //gibt alle inhalte zurück, wo Verknüpfung zw hobby und Tag Id gegeben ist!
            //quasi Pivot TAbelle
            ->orderBy('updated_at', 'DESC');

    }
}
