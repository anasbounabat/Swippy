<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Annonces') }}
            </h2>
            <a href="{{ route('annonces.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Créer une annonce
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 rounded-lg shadow p-8 mb-8">
                <div class="mb-6 md:mb-0 md:w-1/2">
                    <h1 class="text-3xl font-bold mb-4">Prêt à faire du tri dans tes placards ?</h1>
                    <a href="{{ route('annonces.create') }}" class="inline-block px-6 py-3 bg-teal-600 text-white rounded-md font-semibold text-lg hover:bg-teal-700 transition mb-2">Commencer à vendre</a>
                    <br>
                    <a href="#" class="text-teal-700 hover:underline">Découvrir comment ça marche</a>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/1042/1042330.png" alt="Troc" class="w-64 h-64 object-contain rounded-lg shadow-lg" />
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($annonces as $annonce)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        @if($annonce->photo)
                            <img src="{{ Storage::url($annonce->photo) }}" alt="{{ $annonce->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-400 dark:text-gray-500">Pas de photo</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $annonce->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ Str::limit($annonce->description, 100) }}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $annonce->category->name }}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Par {{ $annonce->user->name }}
                                </span>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('annonces.show', $annonce) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                    Voir les détails
                                </a>
                                @if(auth()->id() === $annonce->user_id)
                                    <div class="flex space-x-2">
                                        <a href="{{ route('annonces.edit', $annonce) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                                            Modifier
                                        </a>
                                        <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $annonces->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 