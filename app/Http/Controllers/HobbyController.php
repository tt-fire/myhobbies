<?php

namespace App\Http\Controllers;

use App\Hobby;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; //carbon ist für die direkte anwendung in der Ausgabe verantwortlich!
use Illuminate\Support\Facades\Session; // um die Session zu erweitern, für Rück-Meldung von Tags wiedergabe!
use Intervention\Image\Facades\Image; //einbinden von Intervention = Bildbearb.

//für Autorisierung!
use Illuminate\Support\Facades\Gate; // gate fassade für Login bzw. Autorisierung

class HobbyController extends Controller
{

    // Konstruktor - wird immer aufgerufen, wenn eine Klasse aufgerufen wird!
    // für Auth - bzw. Autorisierung
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); // gleicher effekt wie wenn in web.php mit ->middleware('auth') 
        // hier kann man verschiedene methoden ausnehmen! zb. Index Seite und Detail!

    }


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

        //meldung success mit Facades rein laden und neu übergeben, dass der Back button von Del richtig funktioniert
        $meldung_success = Session::get('meldung_success');


        // dd($hobbies); //DD steht für Dump und Die
        //zeigt alle Datensätze an
        return view('hobby.index')->with(
            [
                'hobbies' => $hobbies,
                'meldung_success' => $meldung_success
            ]
        );
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
                'beschreibung' => 'required|min:5',
                'bild' => 'mimes:jpg,jpeg,bmp,png,gif'
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

        if($request->bild){
            $this->saveImages($request->bild, $hobby->id);
        }



        //return redirect('/hobby'); //für die Ausgabe des Erfolges wird die Index Methode wieder aufgerufen! deshalb auskommentiert
        // weil bei return geht es über die URL dann erst auf die index dabei ginge das "with" verloren!
        /*
        // weiterleiten auf Detail-seite
        return $this->index()->with([
            'meldung_success' => 'Das Hobby <b>' . $hobby->name . '</b> wurde angelegt.'
        ]);
        */

        //nach dem Anlegen von Name und info -> zur Detailansicht weiterleiten!
        return redirect('/hobby/' . $hobby->id)->with(
            [
                'meldung_hinweis' => 'Bitte weise ein paar Tags zu!'
            ]
        );
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


        $meldung_success = Session::get('meldung_success'); //die Meldung Success von hobbyTagController auffangen und erneut wiedergeben!
        $meldung_hinweis = Session::get('meldung_hinweis'); //die Meldung Hinweis von create funktion erneuern

        //zeigt einen einzelnen Datensatz an
        return view('hobby.show')->with(
            [
                'meldung_hinweis' => $meldung_hinweis,
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

        if (auth()->guest()) {
            abort(403, "nur für User");
        }

        abort_unless($hobby->user_id === auth()->id() || auth()->user()->rolle === 'admin' , 403, 'nicht erlaubt');
        // wenn eine der beiden bedingungen nicht erfüllt ist dann Fehler sonst ok!



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

        abort_unless(Gate::allows('update', $hobby), 403, "update nicht erlaubt");
        // mit Gate wird abgefragt, ob der User nach der HobbyPolicy das recht zum delete hat --> delete auf
        // das delete in der Hobby Policy verwiesen!



        //schreibt das bearbeitete Hobby in die DB
        // benötigt die Methode PUT oder Patch -> im Formular Hidden Feld "@method(put)"!!!
        // request = felder evt. bearbeitet; hobby = instanz die bearbeitet wird
        
        // im prinzip von der "store" 
        
        $request->validate( //laravel validation!
          [
            'name' => 'required|min:3', //muss gefüllt sein und mind. 3 Zeichen!
            // nachschauen unter Laravel Docs Validation und Version!
            'beschreibung' => 'required|min:5',
            'bild' => 'mimes:jpg,jpeg,bmp,png,gif' //Datei eigenschaften einschränken usw...
          ]
        );

        if($request->bild){
            $this->saveImages($request->bild, $hobby->id);
        }
        
        
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
        if (auth()->guest()) {
            abort(403, "nur für User");
        }

        abort_unless(Gate::allows('delete', $hobby), 403, 'nicht erlaubt');
        // mit Gate wird abgefragt, ob der User nach der HobbyPolicy das recht zum delete hat --> delete auf
        // das delete in der Hobby Policy verwiesen!

        $oldName = $hobby->name;
        
        $hobby->delete();
        
        //return $this->index()->with([     //damit kommt man immer auf die Index zurück jedoch hin und wieder nicht gewollt!
        return back()->with([
            'meldung_success' => 'Das Hobby <b>' . $oldName . '</b> wurde ​ gelöscht!​'
        ]);
    }

    public function saveImages($bildInput, $hobby_id) {
        $bild = Image::make($bildInput);
        $breite = $bild->width();
        $hoehe = $bild->height();
        if($breite > $hoehe) {
            //dd("Querformat");

            //Querformat
            Image::make($bildInput)
                ->widen(1200)
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg')
                ->widen(400)->pixelate(12) //verpixeltes Bild für nicht eingeloggte!
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg');

            Image::make($bildInput)
                ->widen(60)
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg');
        } else {
            //dd("Hochformat");

            //Hochformat - Umwandlung
            Image::make($bildInput)
                ->heighten(900)
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg')
                ->heighten(400)->pixelate(12) //verpixeltes Bild für nicht eingeloggte!
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg');

            Image::make($bildInput)
                ->heighten(60)
                ->save(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg');
        }
    }

    public function deleteImages($hobby_id) {
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg'))
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg'); //unlink = php zum löschen von Datei!
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg'))
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg');
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg'))
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg');
        return back(); //brauchen eine route!
    }
}
