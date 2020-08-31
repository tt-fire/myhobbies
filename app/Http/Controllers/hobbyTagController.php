<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag; //weil mit TAg model gearbeitet wird!
use App\Hobby;

class hobbyTagController extends Controller
{
    //gibt gefilterte Hobbys zurück
    public function getFilteredHobbies($tag_id) {
        //echo "filtern nach Tag id: " . $tag_id;
        $tag = new Tag();

        $filter = $tag::findOrFail($tag_id);

        /*
        $filteredHobbies = $filter->filteredHobbies()->paginate(10);
        // findOrFail - besser als nur find um Fehler zu vermeiden!wenn er nichts findet dann bricht er ab!
        // filteredHobbies() = funktion im Model TAg Beziehung für das Filtern!
        // paginate (10) damit 10 stk je seite Ausageb!

        return view('hobby.filteredByTag')->with(    //with um variablen anzuhängen!, man kann sie aber auch als 2tes Argument anhängen!
            [
                'hobbies' => $filteredHobbies,
                'tag' => $filter
            ]
        );
        */

        // bessere Variante ohne eigener view - datei .... dafür mit Filter im hobby.index - view!
        $hobbies = $tag::findOrFail($tag_id)->filteredHobbies()->paginate(10);

        return view('hobby.index')->with(
            [
                'hobbies' => $hobbies,
                'filter' => $filter
            ]
            );


    } 

    // zum hinzufügen und entfernen von Tags bei den Hobbies
    // route in Webs

    public function attachTag($hobby_id, $tag_id){

        //filtern der hobbies nach der Hobby ID
        $hobby = Hobby::find($hobby_id);
        //diesem Hobby dann den Tag hinzufügen
        $hobby->tags()->attach($tag_id);

        $tag = Tag::find($tag_id); //für Ausgabe des Tags in der Meldung!

        //Ausgabe: mit Bestätigungsmeldung in der Detailansicht!
        return back()->with('meldung_success', 'Der Tag <b>'. $tag->name .'</b> wurde erfolgreich hinzugefügt.');

    }

    public function detachTag($hobby_id, $tag_id){
       
        $hobby = Hobby::find($hobby_id);
        $hobby->tags()->detach($tag_id);

        $tag = Tag::find($tag_id);

        return back()->with('meldung_success', 'Der Tag <b>'. $tag->name .'</b> wurde erfolgreich entfernt.');

    }

}
