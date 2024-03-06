<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Meeting;
use App\Models\Role;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::guard()->check() && Auth::user()->role->nom === 'Promoteur') {
            return redirect('/mes-medias');
        }

        return view('index');
    }

    public function statistiquesAttente(Request $request, $niveau) {
        $nombre = Media::nombreMediaAttente($niveau);
        return response()->json([
            'nombre' => $nombre
        ]);
    }

    public function statistiquesEnEtude(Request $request, $niveau) {
        $nombre = Media::nombreMediaEtude($niveau);
        return response()->json([
            'nombre' => $nombre
        ]);
    }


    public function statistiquesRejetes(Request $request, $niveau)
    {
        $nombre = Media::nombreMediaRejete($niveau);
        return response()->json([
            'nombre' => $nombre
        ]);
    }
}