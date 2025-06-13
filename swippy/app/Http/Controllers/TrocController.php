<?php

namespace App\Http\Controllers;

use App\Models\Troc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrocController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'objet_offert_id' => 'required|integer',
            'objet_demande_id' => 'required|integer',
            'user_cible_id' => 'required|integer',
        ]);

        Troc::create([
            'objet_offert_id' => $request->objet_offert_id,
            'objet_demande_id' => $request->objet_demande_id,
            'user_propose_id' => Auth::id(),
            'user_cible_id' => $request->user_cible_id,
        ]);

        return redirect('/objets');
    }

    public function accepter(Troc $troc)
    {
        // Exemple de logique d'acceptation (à adapter selon besoin)
        $troc->update(['status' => 'accepté']);
        return redirect('/objets');
    }
}
