<!-- resources/views/components/navbar.blade.php -->
<script src="https://cdn.tailwindcss.com"></script>

<nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-4">
                <div class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</div>
                {{-- <div class="relative">
                    <input type="text" placeholder="Search developers, posts, or #tags"
                        class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div> --}}

                <div class="container mx-auto mt-5 px-4">
                    <div class="flex flex-row gap-6 items-center">
                        <!-- Barre de recherche -->
                        <div class="relative">
                            <input type="text" id="search_text"
                                class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200"
                                placeholder="Rechercher un post ou un utilisateur...(tags)">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <div id="result"
                                class="absolute w-full mt-2 bg-black border border-gray-200 rounded-lg shadow-lg z-10 hidden">
                                <!-- Résultats de la recherche -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('posts.index') }}" class="flex items-center space-x-1 hover:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
                <a href="#" class="flex items-center space-x-1 hover:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span class="bg-blue-500 rounded-full w-2 h-2"></span>
                </a>
                {{-- <a href="#" class="flex items-center space-x-1 hover:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="bg-red-500 rounded-full w-2 h-2"></span>
                </a> --}}


                {{-- notification --}}
                <!-- Notification Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-1 hover:text-blue-400 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">
                            {{ auth()->user()->notifications->count() }}
                        </span>
                    </button>

                    <!-- Notification Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute -right-36 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 z-50">
                        <div class="px-4 py-3 border-b dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notifications</h3>
                            <button class="text-xs text-blue-500 hover:text-blue-700">
                                Mark all as read
                            </button>
                        </div>
                        <!-- Notification Items -->
                        <div class="max-h-96 overflow-y-auto">
                            @foreach (auth()->user()->notifications as $notification)
                                <div
                                    class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b last:border-b-0 dark:border-gray-700">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . (auth()->user()->profile_link ?? 'default/user.png')) }}"
                                                class="w-8 h-8 rounded-full" alt="Avatar">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                hmidouche amine
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                @if (is_array($notification->data) && isset($notification->data['comment']))
                                                    {{ $notification->data['comment'] }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                                2 mins ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-4 py-3 text-center border-t dark:border-gray-700">
                            <a href="#" class="text-sm text-blue-500 hover:text-blue-700">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>
                    {{-- </div> --}}

                    <div class="h-8 w-8 rounded-full overflow-hidden">
                        <a href="{{ route('profile.show', ['username' => Auth::user()->name]) }}">
                            <img src="{{ Storage::url(Auth::user()->profile_picture ?? 'images/placeholder.jpg') }}"
                                alt="Profile" class="w-full h-full object-cover" /></a>
                    </div>
                </div>
            </div>
        </div>
</nav>

<script>
    // Attacher un événement keyup sur le champ de recherche pour détecter quand l'utilisateur appuie sur Entrée
    $('#search_text').on('keyup', function(event) {
        if (event.key === 'Enter') {
            let query = $(this).val().trim()

            if (query.length > 0) {
                // Rediriger l'utilisateur vers la page posts.show avec la recherche incluse dans l'URL
                window.location.href = `/posts/show?query=${encodeURIComponent(query)}`;
            } else {
                console.log('Veuillez entrer un terme de recherche.');
            }
        }
    });


    function search_data(search_value) {
        let postsUrl = '/searchPosts?query=' + encodeURIComponent(search_value);
        let usersUrl = '/searchUsers?query=' + encodeURIComponent(search_value);

        // Recherche des posts
        $.ajax({
            url: postsUrl,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let resultDiv = $("#result");
                resultDiv.empty(); // Vide la section avant de rajouter les résultats

                console.log(response); // Ajoutez ceci pour vérifier le contenu

                if (response.success) {
                    response.posts.forEach(function(post) {
                        let userProfilePicture = post.user && post.user.profile_picture ? post.user
                            .profile_picture : '/images/placeholder.jpg';

                        let postHTML = `
                <div class="post-item p-2 hover:bg-gray-100 cursor-pointer flex items-center space-x-4">
                    <img src="${userProfilePicture}" alt="Profile Picture" class="w-10 h-10 rounded-full">
                    <a href="/posts/${post.id}" class="text-blue-500 hover:text-blue-700">
                        <h3 class="font-semibold">${post.title}</h3>
                    </a>
                </div>
            `;
                        resultDiv.append(postHTML);
                    });
                }

                resultDiv.removeClass('hidden'); // Affiche les résultats
            },

            error: function(error) {
                console.error("Erreur lors de la recherche des posts :", error);
            }
        });

        // Recherche des utilisateurs
        $.ajax({
            url: usersUrl,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response)
                let resultDiv = $("#result");
                resultDiv.empty(); // Vide la section avant de rajouter les résultats

                if (response.success) {
                    response.users.forEach(function(user) {
                        let userHTML = `
                            <div class="user-item p-2 hover:bg-gray-100 cursor-pointer">${user.name} (${user.email})</div>
                        `;
                        resultDiv.append(userHTML);
                    });
                }

                resultDiv.removeClass('hidden'); // Affiche les résultats
            },
            error: function(error) {
                console.error("Erreur lors de la recherche des utilisateurs :", error);
            }
        });
    }

    // Écouter la saisie dans la barre de recherche
    $('#search_text').on('input', function() {
        let searchValue = $(this).val();
        search_data(searchValue); // Appelle la fonction de recherche
    });
</script>
