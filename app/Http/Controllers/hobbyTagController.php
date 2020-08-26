<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag; //weil mit TAg model gearbeitet wird!

class hobbyTagController extends Controller
{
    //gibt gefilterte Hobbys zurück
    public function getFilteredHobbies($tag_id) {
        //echo "filtern nach Tag id: " . $tag_id;
        $tag = new Tag();

        $filter = $tag::findOrFail($tag_id);


        $filteredHobbies = $filter->filteredHobbies()->paginate(10);
        // findOrFail - besser als nur find um Fehler zu vermeiden!wenn er nichts findet dann bricht er ab!
        // filteredHobbies() = funktion im Model TAg Beziehung für das Filtern!
        // paginate (10) damit 10 stk je seite Ausageb!

        return view('hobby.filteredByTag')->with(
            [
                'hobbies' => $filteredHobbies,
                'tag' => $filter
            ]
        );
    } 
}
