<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $annonce->title }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('annonces.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Retour aux annonces
                </a>
                @if(auth()->id() !== $annonce->user_id)
                    <a href="{{ route('messages.contact', $annonce) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Contacter
                    </a>
                @endif
                @if(auth()->id() === $annonce->user_id)
                    <a href="{{ route('annonces.edit', $annonce) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Modifier
                    </a>
                    <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                            Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Image de l'annonce -->
                        <div>
                            @if($annonce->photo)
                                <img src="{{ Storage::url($annonce->photo) }}" alt="{{ $annonce->title }}" class="w-full h-96 object-cover rounded-lg">
                            @else
                                <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 dark:text-gray-500">Pas de photo</span>
                                </div>
                            @endif
                        </div>

                        <!-- Détails de l'annonce -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Description</h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $annonce->description }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Catégorie</h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $annonce->category->name }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Statut</h3>
                                <p class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $annonce->status === 'disponible' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($annonce->status) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Publié par</h3>
                                <div class="mt-2 flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($annonce->user->name) }}&background=random" alt="{{ $annonce->user->name }}" class="w-10 h-10 rounded-full">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $annonce->user->name }}</span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Date de publication</h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $annonce->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            @if(auth()->id() !== $annonce->user_id)
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('messages.contact', $annonce) }}" 
                                       class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Contacter {{ $annonce->user->name }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 