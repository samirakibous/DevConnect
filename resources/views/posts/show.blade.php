<!-- resources/views/posts/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-20 px-4 sm:px-6 lg:px-8">
        <!-- Users Section -->
        <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold mb-4">Users</h2>
            <div class="space-y-3">
                @forelse ($users as $user)
                    <div class="user-item p-3 hover:bg-gray-50 transition rounded-md cursor-pointer flex items-center space-x-4">
                        <img src="{{ asset('storage/' . ($user->profile_picture ? $user->profile_picture : '/images/placeholder.jpg')) }}"
                            alt="{{ $user->name }}'s Profile Picture" class="w-12 h-12 rounded-full object-cover">
                            <a href="{{ route('profile.show', ['username' => Auth::user()->name]) }}">
                                <h3 class="font-semibold">{{ $user->name }}</h3>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 italic">No users found.</p>
                @endforelse
            </div>
        </div>

        <!-- Posts Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Posts</h2>
            <div class="space-y-8">
                @forelse ($posts as $post)
                    <!-- Post Content -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Post Header -->
                        <div class="p-6">
                            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

                            <!-- Post Metadata -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full overflow-hidden">
                                        <img src="{{ Storage::url($post->user->profile_picture ?? 'images/placeholder.jpg') }}"
                                            alt="{{ $post->user->name }}" class="w-12 h-12 object-cover" />
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                        <div class="text-gray-500 text-sm">
                                            <span>Published on {{ $post->created_at->toFormattedDateString() }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Edit/Delete for post owner -->
                                @if(auth()->check() && auth()->id() === $post->user_id)
                                <div class="flex space-x-3">
                                    <a href="{{ route('posts.edit', $post->id) }}" 
                                        class="text-gray-500 hover:text-gray-700 flex items-center transition">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 flex items-center transition"
                                            type="submit" onclick="return confirm('Are you sure you want to delete this post?')">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>

                            <!-- Categories and Tags -->
                            @if($post->hashtags->count() > 0)
                            <div class="flex flex-wrap items-center gap-2 mb-6">
                                @foreach ($post->hashtags as $hashtag)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">#{{ $hashtag->name }}</span>
                                @endforeach
                            </div>
                            @endif

                            <!-- Featured Image -->
                            @if($post->image)
                            <div class="mb-6">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Featured Image"
                                    class="w-full h-auto rounded-lg object-cover">
                            </div>
                            @endif

                            <!-- Post Content -->
                            <div class="prose max-w-none ql-snow">
                                <div class="ql-editor" style="padding: 0 !important;">
                                    <div class="mb-4">{!! $post->description !!}</div>
                                </div>
                            </div>

                            <!-- Engagement Metrics -->
                            <div class="flex flex-wrap items-center gap-6 mt-8 pt-6 border-t">
                                <button id="like-button-{{ $post->id }}" data-post-id="{{ $post->id }}"
                                    class="flex items-center {{ $post->likes(auth()->user()) ? 'text-blue-500' : 'text-gray-400 hover:text-blue-500' }} transition"
                                    onclick='likePost({{ $post->id }})'>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <span class="ml-2">{{ $post->likes->count() }}
                                        Like{{ $post->likes->count() != 1 ? 's' : '' }}</span>
                                </button>
                                <button class="text-gray-500 hover:text-blue-500 flex items-center transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <span>{{ $post->comments->count() }} Comments</span>
                                </button>
                                <button class="text-gray-500 hover:text-blue-500 flex items-center transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    <span>Share</span>
                                </button>
                            </div>
                        </div>

                        <!-- Comment Input -->
                        @auth
                        <div class="border-t border-gray-100 pt-6">
                            <form id="commentForm" action="{{ route('comment.store', $post) }}" method="POST"
                                data-post-id="{{ $post->id }}" class="px-6 pb-6">
                                @csrf
                                <div class="flex items-start space-x-4">
                                    <div class="hidden sm:block flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ Storage::url(Auth::user()->profile_picture ?? 'images/placeholder.jpg') }}"
                                            alt="{{ Auth::user()->name }}" class="w-10 h-10 object-cover" />
                                    </div>

                                    <div class="flex-1">
                                        <textarea id="commentContent" name="content"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Add to the discussion..."></textarea>
                                        <button type="submit"
                                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                            Comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endauth

                        <!-- Existing Comments -->
                        @if($post->comments->count() > 0)
                        <div class="border-t border-gray-100">
                            <div id="commentList" class="space-y-6 p-6">
                                <h3 class="font-medium text-lg mb-4">Comments ({{ $post->comments->count() }})</h3>
                                @foreach ($post->comments->sortByDesc('created_at') as $comment)
                                    <div class="flex items-start space-x-4">
                                        <div class="hidden sm:block flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                            <img src="{{ Storage::url($comment->user->profile_picture ?? 'images/placeholder.jpg') }}"
                                                alt="{{ $comment->user->name }}" class="w-10 h-10 object-cover" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-semibold">{{ $comment->user->name }}</h4>
                                                    <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-800">{{ $comment->content }}</p>
                                                <div class="mt-3 flex items-center space-x-4">
                                                    <button class="text-gray-500 hover:text-blue-500 text-sm transition">Reply</button>
                                                    <button class="text-gray-500 hover:text-blue-500 text-sm transition">Like</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </article>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="text-xl font-medium text-gray-500">No posts yet</h3>
                       
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>