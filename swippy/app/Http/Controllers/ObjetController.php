<?php

namespace App\Http\Controllers;

use App\Models\Objet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObjetController extends Controller
{
    public function index()
    {
        $objets = Objet::all();
        return view('objets.index', compact('objets'));
    }

    public function show(Objet $objet)
    {
        return view('objets.show', compact('objet'));
    }

    public function create()
    {
        return view('objets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Objet::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect('/objets');
    }
}
