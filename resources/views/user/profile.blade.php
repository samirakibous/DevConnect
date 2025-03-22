<!-- resources/views/user/profile.blade.php -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kibous Samira - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    @include('components.navbar')
    <div class="min-h-screen bg-gray-100 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <!-- Profile Header Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Cover Photo Area (You can add a cover image here) -->
                <div class="h-40 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                
                <div class="relative px-6 pb-8">
                    <!-- Profile Picture -->
                    <div class="absolute -top-16">
                        <label for="profile_picture" class="cursor-pointer block">
                            <img 
                                src="{{ asset(Auth::user()->profile_picture ? 'storage/' . Auth::user()->profile_picture : 'images/placeholder.jpg') }}"
                                id="profileImage" 
                                alt="Photo de profil"
                                class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-gray-200"
                            >
                        </label>
                    </div>
                    
                    <!-- Profile Actions -->
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('profile.modifier') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-150 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            <span>Modifier le profil</span>
                        </a>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="mt-16">
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ Auth::user()->description }}</p>
                        <div class="flex items-center mt-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span>Taza, Fès-Meknès, Maroc</span>
                        </div>
                    </div>
                    
                    <!-- Bio Section -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-900">Bio</h2>
                        <p class="mt-2 text-gray-700">{{ Auth::user()->bio ?: 'Aucune bio renseignée.' }}</p>
                    </div>
                    
                    <!-- GitHub Link -->
                    <div class="mt-6 flex items-center">
                        <h2 class="text-lg font-semibold text-gray-900 mr-3">GitHub</h2>
                        <a href="{{ Auth::user()->github_link }}" target="_blank" class="text-gray-700 hover:text-black transition duration-150">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Skills and Experience Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Certifications -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Certifications
                        </h2>
                        
                        <div class="flex flex-wrap gap-2">
                            @forelse (Auth::user()->certifications as $certification)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $certification->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 italic">Aucune certification</p>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Competences -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                            </svg>
                            Compétences
                        </h2>
                        
                        <div class="flex flex-wrap gap-2">
                            @forelse (Auth::user()->competences as $competence)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $competence->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 italic">Aucune compétence</p>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Programming Languages -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Langages de programmation
                        </h2>
                        
                        <div class="flex flex-wrap gap-2">
                            @forelse (Auth::user()->languages as $language)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $language->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 italic">Aucun langage</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Projects -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 6a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd" />
                            </svg>
                            Projets
                        </h2>
                        
                        @forelse (Auth::user()->projets as $projet)
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                                <h3 class="font-medium text-blue-800">{{ $projet->title }}</h3>
                                <p class="text-gray-700 mt-1">{{ $projet->description }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Aucun projet</p>
                        @endforelse
                    </div>
                    
                    <!-- Connections -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            Connexions en attente
                        </h2>
                        
                        @if ($connections->isEmpty())
                            <p class="text-gray-500 italic">Vous n'avez encore aucune connexion.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($connections as $connection)
                                    <div class="flex items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <img 
                                            src="{{ asset($connection->user->profile_picture ? 'storage/' . $connection->user->profile_picture : 'images/placeholder.jpg') }}"
                                            alt="Avatar" 
                                            class="w-12 h-12 rounded-full object-cover border border-gray-200"
                                        >
                                        
                                        <div class="ml-4 flex-1">
                                            <h3 class="font-medium text-gray-900">
                                                {{ $connection->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                @if ($connection->status === 'en attente')
                                                    <span class="text-yellow-600">En attente</span>
                                                @elseif ($connection->status === 'accepter')
                                                    <span class="text-green-600">Connecté</span>
                                                @elseif ($connection->status === 'refuser')
                                                    <span class="text-red-600">Refusé</span>
                                                @endif
                                            </p>
                                        </div>
                                        
                                        @if ($connection->status === 'en attente')
                                            <div class="flex space-x-2">
                                                <button 
                                                    onclick="acceptConnection({{ $connection->id }})" 
                                                    class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-medium transition duration-150"
                                                >
                                                    Accepter
                                                </button>
                                                <button 
                                                    onclick="denyConnection({{ $connection->id }})" 
                                                    class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-full text-sm font-medium transition duration-150"
                                                >
                                                    Refuser
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-12 sm:px-6 lg:px-8 max-w-5xl">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Posts</h2>
                
                @forelse ($posts as $post)
                    <article class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden border border-gray-100">
                        <!-- Post Header -->
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition">{{ $post->title }}</h1>
                            
                            <!-- Author and Post Meta -->
                            <div class="flex flex-wrap items-center justify-between mt-4 pb-4 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                                        <img src="{{ Storage::url($post->user->profile_picture ?? 'images/placeholder.jpg') }}" 
                                            alt="{{ $post->user->name }}" 
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $post->user->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $post->created_at->toFormattedDateString() }} · {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Post Actions -->
                                @if (auth()->check() && auth()->id() === $post->user_id)
                                    <div class="flex mt-2 sm:mt-0">
                                        <a href="{{ route('posts.edit', $post->id) }}" 
                                           class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 mr-4 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center text-sm text-red-500 hover:text-red-700 transition"
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Hashtags -->
                            @if ($post->hashtags->count() > 0)
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @foreach ($post->hashtags as $hashtag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            #{{ $hashtag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <!-- Featured Image -->
                            @if ($post->image)
                                <div class="mt-4 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="Featured Image" 
                                         class="w-full h-auto object-cover">
                                </div>
                            @endif
                            
                            <!-- Post Content -->
                            <div class="mt-6 prose max-w-none">
                                <div class="ql-editor" style="padding: 0 !important;">
                                    {!! $post->description !!}
                                </div>
                            </div>
                            
                            <!-- Engagement Section -->
                            <div class="flex flex-wrap items-center gap-4 mt-6 pt-4 border-t border-gray-100">
                                <button id="like-button-{{ $post->id }}" 
                                        data-post-id="{{ $post->id }}" 
                                        class="flex items-center px-3 py-1.5 rounded-lg {{ $post->likes(auth()->user()) ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition"
                                        onclick='likePost({{ $post->id }})'>
                                    <svg class="w-5 h-5 {{ $post->likes(auth()->user()) ? 'text-blue-500' : 'text-gray-400' }}" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span class="ml-2 text-sm font-medium">{{ $post->likes->count() }}</span>
                                </button>
                                
                                <button class="flex items-center px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <span class="ml-2 text-sm font-medium">{{ $post->comments->count() }}</span>
                                </button>
                                
                                <button class="flex items-center px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-50 transition ml-auto">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    <span class="ml-2 text-sm font-medium">Share</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Comment Section -->
                        <div class="bg-gray-50 border-t border-gray-100">
                            <!-- Comment Input -->
                            @auth
                                <div class="p-6">
                                    <form id="commentForm" action="{{ route('comment.store', $post) }}" method="POST" 
                                          data-post-id="{{ $post->id }}">
                                        @csrf
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0 hidden sm:block">
                                                <img src="{{ Storage::url(Auth::user()->profile_picture ?? 'images/placeholder.jpg') }}" 
                                                     alt="{{ Auth::user()->name }}" 
                                                     class="h-10 w-10 rounded-full object-cover">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500">
                                                    <textarea id="commentContent" name="content" rows="3" 
                                                              class="block w-full py-3 px-4 border-0 resize-none focus:ring-0 sm:text-sm" 
                                                              placeholder="Add a comment..."></textarea>
                                                </div>
                                                <div class="mt-3 flex justify-end">
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endauth
                            
                            <!-- Comments List -->
                            @if ($post->comments->count() > 0)
                                <div class="border-t border-gray-200">
                                    <div id="commentList" class="p-6 space-y-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Comments ({{ $post->comments->count() }})
                                        </h3>
                                        
                                        @foreach ($post->comments->sortByDesc('created_at')->take(3) as $comment)
                                            <div class="flex space-x-3 comment-item">
                                                <div class="flex-shrink-0 hidden sm:block">
                                                    <img src="{{ Storage::url($comment->user->profile_picture ?? 'images/placeholder.jpg') }}" 
                                                         alt="{{ $comment->user->name }}" 
                                                         class="h-10 w-10 rounded-full object-cover">
                                                </div>
                                                <div class="flex-1 bg-white rounded-lg border border-gray-200 p-4">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <h4 class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-800">{{ $comment->content }}</p>
                                                    <div class="mt-2 flex space-x-4">
                                                        <button class="text-xs text-gray-500 hover:text-blue-600 transition">Reply</button>
                                                        <button class="text-xs text-gray-500 hover:text-blue-600 transition">Like</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <!-- Load More Comments Link -->
                                        @if ($post->comments->count() > 3)
                                            <div class="text-center pt-2">
                                                <button onclick="showMoreComments({{ $post->id }})" 
                                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Show more comments
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-500 mb-1">No posts yet</h3>
                        <p class="text-gray-400">Start creating your first post now</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
            

    
        </div>

        <script>
            let currentPage = 1; // Page actuelle des commentaires chargés
            const commentsPerPage = 3; // Nombre de commentaires par page

            function showMoreComments(postId) {
                // Augmenter la page pour charger plus de commentaires
                currentPage++;

                // Faire un appel AJAX pour récupérer plus de commentaires
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `/loadMoreComments/${postId}?page=${currentPage}&limit=${commentsPerPage}`, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.comments.length > 0) {
                            // Ajouter les nouveaux commentaires au conteneur
                            const commentList = document.getElementById('commentList');
                            response.comments.forEach(comment => {
                                const commentElement = document.createElement('div');
                                commentElement.classList.add('flex', 'items-start', 'space-x-4', 'comment-item');
                                commentElement.innerHTML = `
                        <div class="hidden sm:block flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                            <img src="${comment.userProfilePicture}" alt="${comment.userName}" class="w-10 h-10 object-cover" />
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold">${comment.userName}</h4>
                                    <span class="text-gray-500 text-sm">${comment.createdAt}</span>
                                </div>
                                <p class="text-gray-800">${comment.content}</p>
                                <div class="mt-3 flex items-center space-x-4">
                                    <button class="text-gray-500 hover:text-blue-500 text-sm transition">Reply</button>
                                    <button class="text-gray-500 hover:text-blue-500 text-sm transition">Like</button>
                                </div>
                            </div>
                        </div>
                    `;
                                commentList.appendChild(commentElement);
                                // Faire défiler vers le bas
                                commentElement.scrollIntoView({
                                    behavior: "smooth",
                                    block: "end"
                                });
                            });

                            // Si aucun commentaire n'est renvoyé, désactiver le lien "View more comments"
                            if (response.comments.length < commentsPerPage) {
                                const loadMoreButton = document.querySelector("a[onclick='showMoreComments(" + postId +
                                    ")']");
                                loadMoreButton.innerText = "No more comments";
                                loadMoreButton.removeAttribute('onclick'); // Désactive l'événement
                            }
                        }
                    }
                };
                xhr.send();
            }



            // Fonction pour accepter la connexion
            function acceptConnection(connectionId) {
    fetch(`/connections/accept/${connectionId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


            // Fonction pour refuser la connexion
            function denyConnection(connectionId) {
                fetch(`/connections/deny/${connectionId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            _method: 'POST',
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload(); // Recharger la page pour voir la mise à jour
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>

</body>

</html>
