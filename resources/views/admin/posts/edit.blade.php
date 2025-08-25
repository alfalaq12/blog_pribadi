@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.posts.index') }}" 
           class="text-gray-600 hover:text-gray-900 p-2 rounded hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Post</h1>
            <p class="text-gray-600 mt-2">Update your blog post</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title *
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $post->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                           placeholder="Enter post title"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Excerpt *
                    </label>
                    <textarea name="excerpt" 
                              id="excerpt" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror"
                              placeholder="Brief description of your post"
                              required>{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Content *
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="15"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                              placeholder="Write your post content here..."
                              required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Options -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Publish</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Publish immediately</span>
                            </label>
                        </div>
                        
                        @if($post->published_at)
                            <p class="text-sm text-gray-600">
                                Published: {{ $post->published_at->format('d M Y, H:i') }}
                            </p>
                        @endif
                        
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="flex-1 bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors font-medium">
                                Update Post
                            </button>
                            <a href="{{ route('admin.posts.index') }}" 
                               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                        </div>
                        
                        @if($post->is_published)
                            <a href="{{ route('post.show', $post) }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View Post
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Category</h3>
                    <select name="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>
                    <div class="space-y-4">
                        <!-- Current Image -->
                        @if($post->featured_image)
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Current image:</p>
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="Current featured image"
                                     class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        
                        <div>
                            <input type="file" 
                                   name="featured_image" 
                                   id="featured_image"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('featured_image') border-red-500 @enderror">
                            @error('featured_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $post->featured_image ? 'Upload new image to replace current one.' : '' }} 
                                Max 2MB. JPG, PNG, GIF allowed.
                            </p>
                        </div>
                        
                        <!-- New Image Preview -->
                        <div id="image-preview" class="hidden">
                            <p class="text-sm text-gray-600 mb-2">New image preview:</p>
                            <img id="preview-img" class="w-full h-32 object-cover rounded-lg" alt="Preview">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('featured_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection