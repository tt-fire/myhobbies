<?php

namespace App\Http\Controllers;

use App\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hobbies = Hobby::all();
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
                'beschreibung' => $request['beschreibung']

            ]
        );
        $hobby->save();
        //return redirect('/hobby'); //für die Ausgabe des Erfolges wird die Index Methode wieder aufgerufen! deshalb auskommentiert
        // weil bei return geht es über die URL dann erst auf die index dabei ginge das "with" verloren!
        return $this->index()->with([
            'meldung_success' => 'Das Hobby <b>' . $hobby->name . '</b> wurde angelgt.'
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
        //zeigt einen einzelnen Datensatz an
        return view('hobby.show')->with('hobby', $hobby);
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
    }
}
