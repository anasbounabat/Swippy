<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('messages.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=random" 
                         alt="{{ $otherUser->name }}" 
                         class="w-10 h-10 rounded-full">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $otherUser->name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($messages->count() > 0)
                                Dernière activité {{ $messages->last()->created_at->diffForHumans() }}
                            @else
                                Nouvelle conversation
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Zone de chat -->
                <div class="h-96 flex flex-col">
                    <!-- Messages -->
                    <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                        @if($messages->count() > 0)
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs lg:max-w-md">
                                        <div class="flex items-end space-x-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                            @if($message->sender_id !== auth()->id())
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($message->sender->name) }}&background=random" 
                                                     alt="{{ $message->sender->name }}" 
                                                     class="w-8 h-8 rounded-full flex-shrink-0">
                                            @endif
                                            
                                            <div class="bg-{{ $message->sender_id === auth()->id() ? 'indigo' : 'gray' }}-100 dark:bg-{{ $message->sender_id === auth()->id() ? 'indigo' : 'gray' }}-700 rounded-lg px-4 py-2">
                                                @if($message->annonce)
                                                    <div class="mb-2 p-2 bg-white dark:bg-gray-800 rounded border">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">À propos de l'annonce :</p>
                                                        <p class="text-sm font-medium">{{ $message->annonce->title }}</p>
                                                    </div>
                                                @endif
                                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $message->content }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $message->created_at->format('H:i') }}
                                                    @if($message->sender_id === auth()->id())
                                                        @if($message->isRead())
                                                            <span class="ml-1">✓✓</span>
                                                        @else
                                                            <span class="ml-1">✓</span>
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Aucun message pour le moment. Commencez la conversation !</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Zone de saisie -->
                    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                        <form id="message-form" class="flex space-x-4">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                            <div class="flex-1">
                                <textarea name="content" 
                                          id="message-content"
                                          rows="2"
                                          class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm resize-none"
                                          placeholder="Tapez votre message..."
                                          required></textarea>
                            </div>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll vers le bas
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Gestion du formulaire de message
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const content = formData.get('content').trim();
            
            if (!content) return;
            
            // Envoyer le message via AJAX
            fetch('{{ route("messages.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ajouter le message à l'interface
                    addMessageToChat(data.message);
                    
                    // Vider le champ de saisie
                    document.getElementById('message-content').value = '';
                    
                    // Scroll vers le bas
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });

        function addMessageToChat(message) {
            const messagesContainer = document.getElementById('messages-container');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-end';
            
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            
            messageDiv.innerHTML = `
                <div class="max-w-xs lg:max-w-md">
                    <div class="flex items-end space-x-2 flex-row-reverse space-x-reverse">
                        <div class="bg-indigo-100 dark:bg-indigo-700 rounded-lg px-4 py-2">
                            <p class="text-sm text-gray-900 dark:text-gray-100">${message.content}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                ${timeString} ✓
                            </p>
                        </div>
                    </div>
                </div>
            `;
            
            messagesContainer.appendChild(messageDiv);
        }

        // Auto-refresh des messages toutes les 5 secondes
        setInterval(function() {
            fetch('{{ route("messages.show", $otherUser->id) }}')
                .then(response => response.text())
                .then(html => {
                    // Extraire les nouveaux messages et les ajouter
                    // (Simplifié pour l'exemple)
                });
        }, 5000);
    </script>
</x-app-layout> 