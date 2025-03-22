@include('components.navbar')
<div class="container ">
    <h1 class="text-2xl font-bold mb-4 ">Démarrer une nouvelle conversation</h1>

    <form action="{{ route('conversations.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="recipient" class="block text-gray-700">Sélectionner un utilisateur :</label>
            <select name="recipient_id" id="recipient" class="w-full p-2 border rounded">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="message" class="block text-gray-700">Premier message :</label>
            <textarea name="message" id="message" class="w-full p-2 border rounded" required></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Démarrer la conversation
        </button>
    </form>
    
</div>