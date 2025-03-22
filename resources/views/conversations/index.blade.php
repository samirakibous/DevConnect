@include('components.navbar')
<div class="min-h-screen bg-gray-100 py-12">
<div class="container mx-auto p-4 max-w-4xl mt-16">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Mes Conversations</h2>
        
        @if($conversations->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p>Vous n'avez pas encore de conversations.</p>
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($conversations as $conversation)
                    @php
                        // On récupère l'autre utilisateur de la conversation
                        $otherUser = $conversation->user_one == auth()->id() ? $conversation->userTwo : $conversation->userOne;
                        
                        // Récupérer le dernier message si nécessaire
                        $lastMessage = $conversation->messages()->latest()->first();
                    @endphp
                    
                    <li class="py-3 hover:bg-gray-50 rounded-md transition-colors duration-150">
                        <a href="{{ route('conversations.show', $conversation->id) }}" class="flex items-center px-2">
                            <div class="flex-shrink-0">
                                <img
                                    src="{{ asset('storage/' . ($otherUser->profile_picture ?? 'default.png')) }}"
                                    alt="Photo de profil de {{ $otherUser->name }}"
                                    class="w-12 h-12 rounded-full object-cover border border-gray-200"
                                >
                            </div>
                            
                            <div class="ml-4 flex-1 overflow-hidden">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-base font-semibold text-gray-800">{{ $otherUser->name ?? 'Utilisateur inconnu' }}</h3>
                                    
                                    @if($lastMessage)
                                        <span class="text-xs text-gray-500">
                                            {{ $lastMessage->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($lastMessage)
                                    <p class="text-sm text-gray-600 truncate mt-1">
                                        {{ Str::limit($lastMessage->content, 50) }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic mt-1">
                                        Pas de messages
                                    </p>
                                @endif
                            </div>
                            
                            <div class="ml-2">
                                {{-- @if($conversation->unreadCount() > 0)
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                                        {{ $conversation->unreadCount() }}
                                    </span>
                                @endif --}}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
</div>