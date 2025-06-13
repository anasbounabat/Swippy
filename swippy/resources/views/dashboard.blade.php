<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- En-tête avec les statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Objets</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_objets'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Objets Disponibles</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $stats['objets_disponibles'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Trocs</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_trocs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Taux de Réussite</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $taux_reussite }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et Favoris -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Graphique des trocs par mois -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Évolution des Trocs (6 derniers mois)</h3>
                <div style="height: 300px;">
                    <canvas id="trocsChart"></canvas>
                </div>
            </div>

            <!-- Bloc Mes favoris -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Mes favoris
                </h3>
                @if(isset($favoris) && $favoris->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($favoris as $annonce)
                            <div class="bg-gray-50 rounded-xl shadow p-3 flex flex-col group hover:shadow-lg transition">
                                <div class="relative h-32 rounded-lg overflow-hidden mb-2">
                                    @if(!empty($annonce->photo))
                                        <img src="{{ $annonce->photo }}" alt="Image de l'annonce" class="object-cover w-full h-full group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="flex items-center justify-center w-full h-full bg-gradient-to-tr from-indigo-100 via-indigo-200 to-indigo-300">
                                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2">
                                        <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col">
                                    <h4 class="font-semibold text-gray-800 truncate">{{ $annonce->title }}</h4>
                                    <span class="text-sm text-gray-500 mb-1 truncate">{{ $annonce->category->name ?? '' }}</span>
                                    <span class="text-indigo-600 font-bold">{{ $annonce->price ? number_format($annonce->price, 0, ',', ' ') . ' €' : 'À échanger' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-400 text-center py-8">
                        <svg class="mx-auto w-12 h-12 mb-2 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Aucun favori pour le moment.
                    </div>
                @endif
            </div>
        </div>

        <!-- Derniers trocs et objets populaires -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Derniers trocs -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Derniers Trocs</h3>
                <div class="space-y-4">
                    @forelse($derniers_trocs as $troc)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $troc->objetOffert->title }} ↔ {{ $troc->objetDemande->title }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $troc->userPropose->id === auth()->id() ? 'Proposé à' : 'Reçu de' }} 
                                        {{ $troc->userPropose->id === auth()->id() ? $troc->userCible->name : $troc->userPropose->name }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-sm rounded-full
                                    @if($troc->status === 'accepté') bg-green-100 text-green-800
                                    @elseif($troc->status === 'refusé') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($troc->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $troc->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun troc récent</p>
                    @endforelse
                </div>
            </div>

            <!-- Objets les plus demandés -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Objets les Plus Demandés</h3>
                <div class="space-y-4">
                    @forelse($objets_populaires as $objet)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $objet->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $objet->category->name }}</p>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $objet->trocs_demandes_count }} demandes
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun objet populaire</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Mes annonces -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Mes dernières annonces
                    </h3>
                    <a href="{{ route('annonces.index', ['my_annonces' => true]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Voir toutes mes annonces
                    </a>
                </div>

                @if($annonces->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Vous n'avez pas encore créé d'annonce</p>
                        <a href="{{ route('annonces.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Créer une annonce
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($annonces as $annonce)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                                @if($annonce->photo)
                                    <img src="{{ Storage::url($annonce->photo) }}" alt="{{ $annonce->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-gray-400 dark:text-gray-500">Pas de photo</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $annonce->title }}
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        {{ Str::limit($annonce->description, 100) }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $annonce->status === 'disponible' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($annonce->status) }}
                                        </span>
                                        <a href="{{ route('annonces.show', $annonce) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                            Voir les détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données pour le graphique des trocs
        const trocsData = {!! json_encode($trocs_par_mois->map(function($item) {
            return [
                'label' => \Carbon\Carbon::createFromDate($item->annee, $item->mois, 1)->format('M Y'),
                'total' => $item->total
            ];
        })) !!};

        // Données pour le graphique des catégories
        const categoriesData = {!! json_encode($objets_par_categorie->map(function($item) {
            return [
                'name' => $item->name,
                'total' => $item->total
            ];
        })) !!};

        // Graphique des trocs par mois
        const trocsCtx = document.getElementById('trocsChart');
        if (trocsCtx) {
            new Chart(trocsCtx, {
                type: 'line',
                data: {
                    labels: trocsData.map(item => item.label),
                    datasets: [{
                        label: 'Nombre de trocs',
                        data: trocsData.map(item => item.total),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Graphique des objets par catégorie
        const categoriesCtx = document.getElementById('categoriesChart');
        if (categoriesCtx) {
            new Chart(categoriesCtx, {
                type: 'doughnut',
                data: {
                    labels: categoriesData.map(item => item.name),
                    datasets: [{
                        data: categoriesData.map(item => item.total),
                        backgroundColor: [
                            'rgb(99, 102, 241)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)',
                            'rgb(239, 68, 68)',
                            'rgb(139, 92, 246)',
                            'rgb(59, 130, 246)',
                            'rgb(236, 72, 153)',
                            'rgb(168, 85, 247)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>
