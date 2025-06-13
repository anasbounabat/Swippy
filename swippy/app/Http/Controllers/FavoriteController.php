<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Objet;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $objetId = $request->input('objet_id');
        if ($user && $objetId) {
            $user->favorites()->syncWithoutDetaching([$objetId]);
            return response()->json(['success' => true, 'favorited' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $objetId = $request->input('objet_id');
        if ($user && $objetId) {
            $user->favorites()->detach($objetId);
            return response()->json(['success' => true, 'favorited' => false]);
        }
        return response()->json(['success' => false], 400);
    }
}
