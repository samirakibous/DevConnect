@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Messagerie Privée</h2>

        <!-- Zone d'affichage des messages -->
        <div id="messages" class="border border-gray-300 p-4 h-80 overflow-y-auto bg-gray-50 rounded-md">
            @foreach ($messages as $message)
                <div class="p-2 rounded-lg mb-2 {{ $message->sender_id === auth()->id() ? 'bg-blue-200 text-right' : 'bg-gray-200 text-left' }}">
                    <strong>{{ $message->sender->name }}</strong>: {{ $message->content }}
                    <small class="block text-gray-500">{{ $message->created_at->format('H:i') }}</small>
                </div>
            @endforeach
        </div>

        <!-- Formulaire d'envoi de message -->
        <form id="messageForm" class="mt-4 flex space-x-2">
            <input type="hidden" id="receiver_id" value="{{ $receiver->id }}">
            <input type="text" id="messageInput" class="flex-grow p-2 border rounded-md" placeholder="Écrire un message..." required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Envoyer</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messagesContainer = document.getElementById("messages");
        const messageForm = document.getElementById("messageForm");
        const messageInput = document.getElementById("messageInput");
        const receiverId = document.getElementById("receiver_id").value;

        // Écoute les messages en temps réel via Pusher
        Echo.private(`chat.${receiverId}`)
            .listen("MessageSent", (event) => {
                const newMessage = `
                    <div class="p-2 rounded-lg mb-2 ${event.sender_id == {{ auth()->id() }} ? 'bg-blue-200 text-right' : 'bg-gray-200 text-left'}">
                        <strong>${event.sender_id}</strong>: ${event.message}
                        <small class="block text-gray-500">${event.created_at}</small>
                    </div>`;
                messagesContainer.innerHTML += newMessage;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });

        // Envoi d'un message via AJAX
        messageForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message === "") return;

            axios.post("{{ route('messages.send') }}", {
                receiver_id: receiverId,
                content: message
            }).then(response => {
                messageInput.value = "";
            }).catch(error => {
                console.error(error);
            });
        });
    });
</script>
@endpush
