<?php

namespace App\Http\Controllers;

use App\Models\Objet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Objet::with(['user', 'category']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%") ;
            });
        }

        // Si l'utilisateur demande ses propres annonces
        if ($request->has('my_annonces')) {
            $query->where('user_id', auth()->id());
        }

        $annonces = $query->latest()->paginate(12)->appends($request->all());
        return view('annonces.index', compact('annonces'));
    }

    public function show(Objet $annonce)
    {
        $annonce->load(['user', 'category']);
        return view('annonces.show', compact('annonce'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('annonces.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|max:2048'
        ]);

        try {
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('annonces', 'public');
                $validated['photo'] = $path;
            }

            $validated['user_id'] = auth()->id();
            $validated['status'] = 'disponible';

            $annonce = Objet::create($validated);

            return redirect()->route('annonces.index')
                ->with('success', 'Annonce créée avec succès !');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la création de l\'annonce. Veuillez réessayer.']);
        }
    }

    public function edit(Objet $annonce)
    {
        $this->authorize('update', $annonce);
        $categories = Category::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    public function update(Request $request, Objet $annonce)
    {
        $this->authorize('update', $annonce);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($annonce->photo) {
                Storage::disk('public')->delete($annonce->photo);
            }
            $path = $request->file('photo')->store('annonces', 'public');
            $validated['photo'] = $path;
        }

        $annonce->update($validated);

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce mise à jour avec succès !');
    }

    public function destroy(Objet $annonce)
    {
        $this->authorize('delete', $annonce);

        if ($annonce->photo) {
            Storage::disk('public')->delete($annonce->photo);
        }

        $annonce->delete();

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès !');
    }
}
