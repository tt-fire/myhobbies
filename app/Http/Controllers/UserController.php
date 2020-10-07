<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; //einbinden von Intervention = Bildbearb.

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //einzelnen Datensatz bearbeiten
        return view('user.edit')->with('user' , $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //schreibt den bearbeiteten user in die DB
        // benötigt die Methode PUT oder Patch -> im Formular Hidden Feld "@method(put)"!!!
        // request = felder evt. bearbeitet; hobby = instanz die bearbeitet wird
        
        // im prinzip von der "store" 
        
        $request->validate( //laravel validation!
            [
              'motto' => 'required|min:3', //muss gefüllt sein und mind. 3 Zeichen!
              // nachschauen unter Laravel Docs Validation und Version!
              'ueber_mich' => 'required|min:5',
              'bild' => 'mimes:jpg,jpeg,bmp,png,gif' //Datei eigenschaften einschränken usw...
            ]
          );
  
          if($request->bild){
              $this->saveImages($request->bild, $user->id);
          }
          
          
          // user schreiben - update!
          $user->update([
              'motto' => $request->motto,
              'ueber_mich' => $request->ueber_mich
              
          ]);

          return redirect('/home');
  
          /*
          return $this->index()->with([
              'meldung_success' => 'Das Profil <b>' . $request->name . '</b> wurde erfolgreich bearbeitet.'
          ]);
          */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function saveImages($bildInput, $user_id) {
        $bild = Image::make($bildInput);
        $breite = $bild->width();
        $hoehe = $bild->height();
        if($breite > $hoehe) {
            //dd("Querformat");

            //Querformat
            Image::make($bildInput)
                ->widen(500)
                ->save(public_path() . '/img/user/User_' . auth()->id() . '.jpg')
                ->widen(300)->pixelate(12) //verpixeltes Bild für nicht eingeloggte!
                ->save(public_path() . '/img/user/User_' . $user_id . '_verpixelt.jpg');

            Image::make($bildInput)
                ->widen(60)
                ->save(public_path() . '/img/user/User_' . auth()->id() . '_thumb.jpg');
        } else {
            //dd("Hochformat");

            //Hochformat - Umwandlung
            Image::make($bildInput)
                ->heighten(500)
                ->save(public_path() . '/img/user/User_' . auth()->id() . '.jpg')
                ->heighten(300)->pixelate(12) //verpixeltes Bild für nicht eingeloggte!
                ->save(public_path() . '/img/user/User_' . auth()->id() . '_verpixelt.jpg');

            Image::make($bildInput)
                ->heighten(60)
                ->save(public_path() . '/img/user/User' . auth()->id() . '_thumb.jpg');
        }
    }

    public function deleteImages() {
        if (file_exists(public_path() . '/img/user/User_' . auth()->id() . '_thumb.jpg'))
            unlink(public_path() . '/img/user/User_' . auth()->id() . '_thumb.jpg'); //unlink = php zum löschen von Datei!
        if (file_exists(public_path() . '/img/user/User_' . auth()->id() . '.jpg'))
            unlink(public_path() . '/img/user/User_' . auth()->id() . '.jpg');
        if (file_exists(public_path() . '/img/user/User_' . auth()->id() . '_verpixelt.jpg'))
            unlink(public_path() . '/img/user/User_' . auth()->id() . '_verpixelt.jpg');
        return back(); //brauchen eine route!
    }

}
