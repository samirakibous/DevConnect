<!-- resources/views/user/profile.blade.php -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kibous Samira - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    @include('components.navbar')
    <div class="bg-gray-100 text-gray-800 pt-10">

        <div class="container mx-auto p-4 pt-10">

            <div class="bg-white shadow-lg rounded-lg pt-10 pb-10">

                <div class="flex justify-end m-4 ">
                    <a href="{{ route('profile.modifier') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Modifier le profil
                    </a>
                </div>

                <label for="profile_picture" class="cursor-pointer ">
                    <!-- Vérifie si l'utilisateur a une image de profil, sinon affiche une image par défaut -->
                    <img src="{{ asset(Auth::user()->profile_picture ? 'storage/' . Auth::user()->profile_picture : 'images/placeholder.jpg') }}"
                        id="profileImage" alt="Cliquez pour choisir une photo"
                        class="w-32 h-32 rounded-full mx-auto border-2 border-gray-300 bg-gray-200">
                </label>

                <div class="m-4">
                    <h2 class="text-xl font-semibold">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600">{{ Auth::user()->description }}</p>
                    <p class="text-gray-600">Taza, Fès-Meknès, Maroc · Coordonnées</p>
                </div>

                <div class="m-4">
                    <h3 class="text-lg font-semibold">Bio</h3>
                    <p class="text-gray-600">{{ Auth::user()->bio }}</p>
                </div>

                <div class="m-4">
                    <h3 class="text-lg font-semibold">Lien GitHub </h3>
                    <a href="{{ Auth::user()->github_link }}" target="_blank" class="text-gray-600 hover:text-black">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                    </a>
                </div>

                <div class="m-4">
                    <h3 class="text-lg font-semibold">Certifications</h3>
                    <p>{{ Auth::user()->certification }}</p>
                </div>
                

            </div>
            <div class="bg-white shadow-lg rounded-lg mt-4 p-4">
                <h3 class="text-lg font-semibold">Competences</h3>

                @foreach (Auth::user()->competences as $competence)
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                        {{ $competence->name }}
                    </span>
                @endforeach

            </div>
            <div class="bg-white shadow-lg rounded-lg mt-4 p-4">
                <h3 class="text-lg font-semibold">Connexions en attente</h3>

                @if ($connections->isEmpty())
                    <p class="text-gray-500">Vous n'avez encore aucune connexion.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($connections as $connection)
                            <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow-sm">
                                <img src="{{ asset(Auth::user()->profile_picture ? 'storage/' . Auth::user()->profile_picture : 'images/placeholder.jpg') }}" alt="Avatar"
                                    class="w-12 h-12 rounded-full object-cover">

                                <div class="ml-4">
                                    <h3 class="text-lg font-medium">
                                        {{ $connection->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">jjjjj</p>
                                </div>

                                <div class="ml-auto">
                                    <a href="#" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                        💬 Message
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif

            </div>

        </div>

</body>

</html>
