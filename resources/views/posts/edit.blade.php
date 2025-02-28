<x-app-layout name="edit-post">

    <main class="max-w-4xl mx-auto mt-8 px-4">


        <!-- Create Post Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Create New Post</h1>

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                <!-- CSRF Token -->
                @method('PUT')
                @csrf
                <!-- Title Input -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
                    <input value="{{ old('title', $post->title) }}" type="text" id="title" name="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter post title">
                    @error('title')
                        <div>
                            <p class="mt-1 text-sm text-gray-500 text-red-700">{{ $message }}</p>
                        </div>
                    @enderror

                </div>



                <select name="tags[]" id="tags"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    multiple>
                    @foreach ($hashtags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Featured Image Upload -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image-upload"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span>
                                    or drag and drop</p>
                                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                            </div>
                            <input id="image-upload" name="image" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    @error('image')
                        <div>
                            <p class="mt-1 text-sm text-gray-500 text-red-700">{{ $message }}</p>
                        </div>
                    @enderror
                    <div id="image-preview" class="mt-4 hidden">
                        <div class="relative w-full h-48 overflow-hidden rounded-lg">
                            <img id="preview-image" src="{{ $post->image }}" alt="Preview"
                                class="w-full h-full object-cover">
                            <button type="button" id="remove-image"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Description/Content -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Post Content</label>
                    <div class="border border-gray-300 rounded-lg p-2 bg-white">
                        <!-- Basic Text Formatting Toolbar -->
                        <div class="flex items-center space-x-3 border-b border-gray-200 pb-2 mb-2">
                            <button type="button" class="p-1 rounded hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 12h12M6 18h12M6 6h12" />
                                </svg>
                            </button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 font-bold">B</button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 italic">I</button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 underline">U</button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </button>
                            <button type="button" class="p-1 rounded hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                        <textarea id="description" name="description" rows="12"
                            class="w-full px-3 py-2 border-none focus:outline-none focus:ring-0"
                            placeholder="Write your post content here...">{{ $post->description }}</textarea>
                        @error('description')
                            <div>
                                <p class="mt-1 text-sm text-gray-500 text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Post Settings -->
                <div class="mb-6 border border-gray-200 rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-3">Post Settings</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="allow_comments" name="allow_comments" checked
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="allow_comments" class="ml-2 text-sm text-gray-700">Allow comments on this
                                post</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="feature_post" name="feature_post"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="feature_post" class="ml-2 text-sm text-gray-700">Feature this post on
                                homepage</label>
                        </div>
                        <div>
                            <label for="publish_date" class="block text-sm text-gray-700 mb-1">Publish Date</label>
                            <input type="datetime-local" id="publish_date" name="publish_date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <button type="button"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Save as Draft
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Publish Post
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Script for image preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageUpload = document.getElementById('image-upload');
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');
            const removeImage = document.getElementById('remove-image');

            imageUpload.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        }

                        reader.readAsDataURL(file);
                    }
                }
            });

            removeImage.addEventListener('click', function() {
                imageUpload.value = '';
                imagePreview.classList.add('hidden');
                previewImage.src = '#';
            });
        });
    </script>
</x-app-layout>
