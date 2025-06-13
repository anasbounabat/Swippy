<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Objet;
use App\Models\Troc;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'users' => User::all(),
            'objets' => Objet::all(),
            'trocs' => Troc::all(),
        ]);
    }
}
