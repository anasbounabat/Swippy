<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Messages') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(count($conversationsWithLastMessage) > 0)
                        <div class="space-y-4">
                            @foreach($conversationsWithLastMessage as $conversation)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
                                    <a href="{{ route('messages.show', $conversation['user']->id) }}" 
                                       class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 relative">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation['user']->name) }}&background=random" 
                                                 alt="{{ $conversation['user']->name }}" 
                                                 class="w-12 h-12 rounded-full">
                                            @if($conversation['unread_count'] > 0)
                                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center">
                                                    {{ $conversation['unread_count'] > 9 ? '9+' : $conversation['unread_count'] }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Contenu -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $conversation['user']->name }}
                                                    </h3>
                                                    @if($conversation['last_message'])
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate max-w-md">
                                                            @if($conversation['last_message']->sender_id === auth()->id())
                                                                <span class="text-gray-500">Vous : </span>
                                                            @endif
                                                            {{ Str::limit($conversation['last_message']->content, 50) }}
                                                        </p>
                                                    @else
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Aucun message
                                                        </p>
                                                    @endif
                                                </div>
                                                
                                                @if($conversation['last_message'])
                                                    <div class="flex-shrink-0 text-right">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $conversation['last_message']->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                Aucune conversation
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">
                                Vous n'avez pas encore de conversations. Commencez par contacter quelqu'un depuis une annonce !
                            </p>
                            <a href="{{ route('annonces.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Voir les annonces
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 