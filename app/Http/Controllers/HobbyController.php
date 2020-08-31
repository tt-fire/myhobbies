<?php

namespace App\Http\Controllers;

use App\Hobby;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; //carbon ist für die direkte anwendung in der Ausgabe verantwortlich!
use Illuminate\Support\Facades\Session; // um die Session zu erweitern, für Rück-Meldung von Tags wiedergabe!

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // alle Hobbies anzeigen:    
        // $hobbies = Hobby::all();

        // nur 10 Hobbies auf einer Seite anzeigen!
        // $hobbies = Hobby::paginate(10);
        // nach Datum sortieren! absteigend
        $hobbies = Hobby::orderBy('created_at','DESC')->paginate(10);

        // dd($hobbies); //DD steht für Dump und Die
        //zeigt alle Datensätze an
        return view('hobby.index')->with('hobbies', $hobbies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //zeigt ein Formular für einen neuen Datensatz an!
        return view('hobby.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //diese funktion muss aufgerufen werden um etwas zu speichern!
        //dd($request); //um zu schauen was ankommt zum testen
        
        // Validierung:
        $request->validate(
            [
                'name' => 'required|min:3', //muss gefüllt sein und mind. 3 Zeichen!
                // nachschauen unter Laravel Docs Validation und Version!
                'beschreibung' => 'required|min:5'
            ]
        );
        
        
        // hobby schreiben
        $hobby = new Hobby(
            [
                'name' => $request->name,
                'beschreibung' => $request['beschreibung'],
                'user_id' => auth()->id() //damit bekommt man die User Id vom eingeloggten User!

            ]
        );
        $hobby->save();
        //return redirect('/hobby'); //für die Ausgabe des Erfolges wird die Index Methode wieder aufgerufen! deshalb auskommentiert
        // weil bei return geht es über die URL dann erst auf die index dabei ginge das "with" verloren!
        return $this->index()->with([
            'meldung_success' => 'Das Hobby <b>' . $hobby->name . '</b> wurde angelegt.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {

        
        $alleTags = Tag::all(); //alle Tags holen!
        $verwTags = $hobby->tags; //die bereits verwendeten Tags
        $verfTags = $alleTags->diff($verwTags); //alle Tags abzüglich der verwendeten!


        $meldung_success = Session::get('meldung_success');

        //zeigt einen einzelnen Datensatz an
        return view('hobby.show')->with(
            [
                'meldung_success' => $meldung_success,
                'verfTags' => $verfTags,
                'hobby'=> $hobby
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        //einzelnen Datensatz bearbeiten
        return view('hobby.edit')->with('hobby' , $hobby);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hobby $hobby)
    {
        //schreibt das bearbeitete Hobby in die DB
        // benötigt die Methode PUT oder Patch -> im Formular Hidden Feld "@method(put)"!!!
        // request = felder evt. bearbeitet; hobby = instanz die bearbeitet wird
        
        // im prinzip von der "store" 
        
        $request->validate(
          [
            'name' => 'required|min:3', //muss gefüllt sein und mind. 3 Zeichen!
            // nachschauen unter Laravel Docs Validation und Version!
            'beschreibung' => 'required|min:5'
          ]
        );
        
        
        // hobby schreiben - update!
        $hobby->update([
            'name' => $request->name,
            'beschreibung' => $request->beschreibung
        ]);

        return $this->index()->with([
            'meldung_success' => 'Das Hobby <b>' . $request->name . '</b> wurde erfolgreich bearbeitet.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {
        //
        $oldName = $hobby->name;
        
        $hobby->delete();
        
        return $this->index()->with([
            'meldung_success' => 'Das Hobby <b>' . $oldName . '</b> wurde ​ gelöscht!​'
        ]);
    }
}
