<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; //damit man session verwenden kann
use App\Hobby;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $meldung_success = Session::get('meldung_success');

        /* --> Problem = nur das hobbie wird geladen nicht Funktionen der anderen models!
        // mit DB... kann man nur auf die eine Tabelle zugreifen, über das Model aber auf 
       // die einzelnen Funktionen!
        $hobbies = DB::table('hobbies')
            ->select()      //Methode von LAravel
            ->where('user_id',auth()->id())
            ->orderBy('updated_at', 'DESC')
            ->get();
            */

        $hobbies = Hobby::select()      //Methode von LAravel
            ->where('user_id',auth()->id())
            ->orderBy('updated_at', 'DESC')
            ->get();

        //dd($hobbies);

        return view('home')->with(
            [
                'hobbies' => $hobbies,
                'meldung_success' => $meldung_success
            ]
        );
    }
}
