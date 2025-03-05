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

</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-20 px-4">

        <!-- Affichage des utilisateurs -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Utilisateurs</h2>
            <div class="space-y-4">
                @forelse ($users as $user)
                    <div class="user-item p-2 hover:bg-gray-100 cursor-pointer flex items-center space-x-4">
                        <img src="{{ $user->profile_picture ? $user->profile_picture : '/images/placeholder.jpg' }}" alt="Profile Picture" class="w-10 h-10 rounded-full">
                        <a href="" class="text-blue-500 hover:text-blue-700">
                            <h3 class="font-semibold">{{ $user->name }}</h3>
                        </a>
                    </div>
                @empty
                    <p>Aucun utilisateur trouvé.</p>
                @endforelse
            </div>
        </div>

        <!-- Affichage des posts -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Posts</h2>
            <div class="space-y-4">
                @forelse ($posts as $post)
                    <div class="post-item p-2 hover:bg-gray-100 cursor-pointer">
                        <h3 class="font-semibold">{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>
                    </div>
                @empty
                    <p>Aucun post trouvé.</p>
                @endforelse
            </div>
        </div>

    </div>

</body>


</html>
