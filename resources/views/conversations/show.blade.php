<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conversation</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@laravel/echo"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <!-- Header -->
    @php
        $otherUser = $conversation->user_one == auth()->id() ? $conversation->userTwo : $conversation->userOne;
    @endphp
    <header class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center">
            <button class="mr-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </button>

            <div class="flex-shrink-0 mr-3">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                    <!-- Profile image or initials -->
                    {{-- <span class="text-gray-700 font-medium">
                        {{ isset($otherUser->name ) ? strtoupper(substr($otherUser->name , 0, 1)) : 'C' }}
                    </span> --}}
                    <img src="{{ asset($otherUser->profile_picture ? 'storage/' . $otherUser->profile_picture : 'images/placeholder.jpg') }}"
                        id="profileImageConv" alt="Photo de profil"
                        class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-gray-200">
                </div>
            </div>

            <div class="flex-1">
                <h1 class="font-medium text-gray-900">{{ $otherUser->name ?? 'Conversation' }}</h1>
                <p class="text-xs text-gray-500">En ligne</p>
            </div>

            <div>
                <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 overflow-hidden flex flex-col max-w-4xl mx-auto w-full bg-white shadow-sm my-4 rounded-lg">
        <!-- Messages container -->
        <div id="message-container" class="flex-1 overflow-y-auto p-4 space-y-4">
            <!-- Date separator -->
            <div class="flex items-center justify-center my-2">
                <div class="bg-gray-200 text-gray-500 text-xs py-1 px-3 rounded-full">
                    Aujourd'hui
                </div>
            </div>

            <!-- Messages -->
            @foreach ($messages as $message)
                @if ($message->sender_id == Auth::id())
                    <!-- Sent message -->
                    <div class="flex justify-end mb-4">
                        <div class="rounded-lg py-2 px-3 bg-blue-500 text-white max-w-md">
                            <p class="text-sm">{{ $message->message }}</p>
                            <p class="text-right text-xs text-blue-200 mt-1">{{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @else
                    <!-- Received message -->
                    <div class="flex mb-4">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 mr-2 overflow-hidden">
                            <!-- Sender avatar could be added here -->
                            <img src="{{ asset($otherUser->profile_picture ? 'storage/' . $otherUser->profile_picture : 'images/placeholder.jpg') }}"
                                id="profileImageConv" alt="Photo de profil"
                                class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-gray-200">
                        </div>
                        <div class="rounded-lg py-2 px-3 bg-gray-100 max-w-md">
                            <p class="text-sm text-gray-800">{{ $message->message }}</p>
                            <p class="text-left text-xs text-gray-500 mt-1">{{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Message input -->
        <div class="border-t border-gray-200 p-4">
            <form id="sendMessageForm" class="flex items-center space-x-2">
                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                        </path>
                    </svg>
                </button>

                <input type="text" id="message"
                    class="flex-1 border border-gray-300 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent transition-colors"
                    placeholder="Envoyer un message..." required>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </main>

    <script>
        // Setup for real-time messaging with Laravel Echo
        window.addEventListener('load', function() {
            window.Pusher = require('pusher-js');
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });

            // Listen for new messages
            window.Echo.private('conversation.{{ $conversation->id ?? 'channel' }}')
                .listen('NewMessage', (e) => {
                    // Add the new message to the UI
                    const isMyMessage = e.message.sender_id === {{ Auth::id() }};
                    const messageHtml = isMyMessage ?
                        `
                            <div class="flex justify-end mb-4">
                                <div class="rounded-lg py-2 px-3 bg-blue-500 text-white max-w-md">
                                    <p class="text-sm">${e.message.message}</p>
                                    <p class="text-right text-xs text-blue-200 mt-1">Just now</p>
                                </div>
                            </div>
                        ` :
                        `
                            <div class="flex mb-4">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 mr-2 overflow-hidden">
                                    <!-- Sender avatar -->
                                </div>
                                <div class="rounded-lg py-2 px-3 bg-gray-100 max-w-md">
                                    <p class="text-sm text-gray-800">${e.message.message}</p>
                                    <p class="text-left text-xs text-gray-500 mt-1">Just now</p>
                                </div>
                            </div>
                        `;

                    const messageContainer = document.getElementById('message-container');
                    messageContainer.insertAdjacentHTML('beforeend', messageHtml);
                    messageContainer.scrollTop = messageContainer.scrollHeight;

                    // Show notification if window is not focused
                    if (!document.hasFocus()) {
                        toastr.info(e.message.message, e.message.sender_name || 'New message');
                    }
                });
        });

        // Form submission with Axios
        document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const messageInput = document.getElementById('message');
            const message = messageInput.value.trim();

            if (!message) return;

            axios.post(`/conversations/{{ $conversation->id }}/messages`, {
                    message: document.getElementById('message').value
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    toastr.error('Erreur lors de l\'envoi du message');
                });

        });


        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to bottom of messages on load
            const messageContainer = document.getElementById('message-container');
            messageContainer.scrollTop = messageContainer.scrollHeight;

            // Set up message form submission
            const form = document.getElementById('sendMessageForm');
            const input = document.getElementById('message');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (input.value.trim() === '') return;

                // Here you would send the message via AJAX
                // For now, let's just append it to the UI
                const messageHtml = `
                    <div class="flex justify-end mb-4">
                        <div class="rounded-lg py-2 px-3 bg-blue-500 text-white max-w-md">
                            <p class="text-sm">${input.value}</p>
                            <p class="text-right text-xs text-blue-200 mt-1">Just now</p>
                        </div>
                    </div>
                `;

                messageContainer.insertAdjacentHTML('beforeend', messageHtml);
                messageContainer.scrollTop = messageContainer.scrollHeight;
                input.value = '';
            });
        });
    </script>
</body>

</html>
