<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @stack('scripts')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left section -->
                        <div class="flex items-center">
                            <a href="/dashboard" class="text-xl font-bold text-indigo-600 dark:text-indigo-400 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/>
                                </svg>
                                Swippy
                            </a>
                            <div class="hidden md:ml-10 md:flex md:space-x-8">
                                <a href="/dashboard" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium text-gray-900 dark:text-white">Dashboard</a>
                                <a href="/annonces" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 hover:border-gray-300">Annonces</a>
                            </div>
                        </div>

                        <!-- Search bar -->
                        <div class="flex-1 flex items-center justify-center">
                            <div class="max-w-7xl w-full px-4 mx-auto">
                                <label for="search" class="sr-only">Rechercher</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Rechercher..." type="search">
                                </div>
                            </div>
                        </div>

                        <!-- Right section -->
                        <div class="hidden md:ml-4 md:flex md:items-center md:space-x-4">
                            <a href="/annonces/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Déposer une annonce
                            </a>

                            <!-- Messages icon -->
                            @auth
                                <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span id="unread-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ auth()->user()->unreadMessagesCount() > 0 ? '' : 'hidden' }}">
                                        {{ auth()->user()->unreadMessagesCount() > 9 ? '9+' : auth()->user()->unreadMessagesCount() }}
                                    </span>
                                </a>
                            @endauth
                            
                            <!-- Profile dropdown -->
                            <div class="ml-4 relative flex-shrink-0">
                                <div>
                                    <button type="button" class="bg-white dark:bg-gray-800 rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    </button>
                                </div>
                                
                                <!-- Dropdown menu -->
                                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">Profil</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block" role="menuitem">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden" id="mobile-menu">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="/dashboard" class="bg-indigo-50 dark:bg-gray-700 border-indigo-500 text-indigo-700 dark:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                        <a href="/annonces" class="border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-800 dark:hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Annonces</a>
                        @auth
                            <a href="{{ route('messages.index') }}" class="border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-800 dark:hover:text-white block pl-3 pr-4 py-2 border-l-4 text-base font-medium flex items-center">
                                Messages
                                @if(auth()->user()->unreadMessagesCount() > 0)
                                    <span class="ml-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ auth()->user()->unreadMessagesCount() > 9 ? '9+' : auth()->user()->unreadMessagesCount() }}
                                    </span>
                                @endif
                            </a>
                        @endauth
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800 dark:text-white">John Doe</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">john@example.com</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="/profile" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Swippy. Tous droits réservés.
                    </p>
                </div>
            </footer>
        </div>

        <script>
            // Gestion du menu utilisateur mobile
            document.getElementById('user-menu').addEventListener('click', function() {
                const menu = this.nextElementSibling;
                menu.classList.toggle('hidden');
            });

            // Mise à jour automatique du compteur de messages non lus
            @auth
            function updateUnreadCount() {
                fetch('{{ route("messages.unread.count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const countElement = document.getElementById('unread-count');
                        if (data.count > 0) {
                            countElement.textContent = data.count > 9 ? '9+' : data.count;
                            countElement.classList.remove('hidden');
                        } else {
                            countElement.classList.add('hidden');
                        }
                    });
            }

            // Mettre à jour le compteur toutes les 30 secondes
            setInterval(updateUnreadCount, 30000);
            @endauth
        </script>
    </body>
</html>