<?php

namespace App\Http\Controllers;

use App\Models\Objet;
use App\Models\Troc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistiques de base
        $stats = [
            'total_objets' => $user->objets()->count(),
            'objets_disponibles' => $user->objets()->where('status', 'disponible')->count(),
            'total_trocs' => Troc::where('user_propose_id', $user->id)
                                ->orWhere('user_cible_id', $user->id)
                                ->count(),
            'trocs_acceptes' => Troc::where(function($query) use ($user) {
                                    $query->where('user_propose_id', $user->id)
                                          ->orWhere('user_cible_id', $user->id);
                                })
                                ->where('status', 'accepté')
                                ->count(),
        ];

        // Statistiques des trocs par mois (6 derniers mois)
        $trocs_par_mois = Troc::where(function($query) use ($user) {
                                $query->where('user_propose_id', $user->id)
                                      ->orWhere('user_cible_id', $user->id);
                            })
                            ->where('created_at', '>=', Carbon::now()->subMonths(6))
                            ->select(
                                DB::raw('MONTH(created_at) as mois'),
                                DB::raw('YEAR(created_at) as annee'),
                                DB::raw('COUNT(*) as total')
                            )
                            ->groupBy('annee', 'mois')
                            ->orderBy('annee')
                            ->orderBy('mois')
                            ->get();

        // Statistiques des objets par catégorie
        $objets_par_categorie = $user->objets()
                                    ->join('categories', 'objets.category_id', '=', 'categories.id')
                                    ->select('categories.name', DB::raw('count(*) as total'))
                                    ->groupBy('categories.name')
                                    ->get();

        // Taux de réussite des trocs
        $total_trocs = $stats['total_trocs'];
        $taux_reussite = $total_trocs > 0 
            ? round(($stats['trocs_acceptes'] / $total_trocs) * 100, 2) 
            : 0;

        // Derniers trocs
        $derniers_trocs = Troc::where(function($query) use ($user) {
                                $query->where('user_propose_id', $user->id)
                                      ->orWhere('user_cible_id', $user->id);
                            })
                            ->with(['objetOffert', 'objetDemande', 'userPropose', 'userCible'])
                            ->latest()
                            ->take(5)
                            ->get();

        // Objets les plus demandés
        $objets_populaires = Objet::whereHas('trocsDemandes', function($query) use ($user) {
                                    $query->where('user_cible_id', $user->id);
                                })
                                ->withCount('trocsDemandes')
                                ->orderBy('trocs_demandes_count', 'desc')
                                ->take(5)
                                ->get();

        $annonces = $user->objets()
            ->with('category')
            ->latest()
            ->take(2)
            ->get();

        return view('dashboard', compact(
            'user',
            'stats',
            'trocs_par_mois',
            'objets_par_categorie',
            'taux_reussite',
            'derniers_trocs',
            'objets_populaires',
            'annonces'
        ));
    }
}
