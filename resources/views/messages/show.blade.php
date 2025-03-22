
@include('components.navbar')
<div class="container mx-auto p-10">
    <h2 class="text-lg font-bold mb-4">Discussion avec {{ $conversation->userOne->id == auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}</h2>
    
    <div class="border p-4 rounded-lg h-96 overflow-y-auto bg-gray-100">
        @foreach ($messages as $message)
            <div class="mb-2 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                <span class="p-2 rounded-lg inline-block {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                    {{ $message->message }}
                </span>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.send', $conversation->id) }}" method="POST" class="mt-4 flex">
        @csrf
        <input type="text" name="message" class="flex-1 p-2 border rounded-lg" placeholder="Écrire un message...">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg">Envoyer</button>
    </form>
</div>
