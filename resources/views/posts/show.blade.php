@extends('layouts.app')

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Post Header -->
    <header class="mb-8">
        <div class="mb-4">
            <a href="{{ route('category.show', $post->category) }}" 
               class="inline-block bg-primary-100 text-primary-600 px-3 py-1 rounded-full text-sm font-medium hover:bg-primary-200 transition-colors">
                {{ $post->category->name }}
            </a>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            {{ $post->title }}
        </h1>
        
        <div class="flex items-center space-x-6 text-gray-600 mb-8">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-medium">{{ substr($post->user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $post->user->name }}</p>
                    <p class="text-sm">{{ $post->published_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->featured_image)
    <div class="mb-8">
        <img src="{{ asset('storage/' . $post->featured_image) }}" 
             alt="{{ $post->title }}"
             class="w-full h-96 object-cover rounded-2xl shadow-lg">
    </div>
    @endif

    <!-- Post Content -->
    <div class="prose prose-lg max-w-none mb-12">
        {!! nl2br(e($post->content)) !!}
    </div>

    <!-- Comments Section -->
    <section class="border-t border-gray-200 pt-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-8">
            Komentar ({{ $post->comments()->approved()->count() }})
        </h3>

        <!-- Comment Form -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
            <h4 class="text-lg font-semibold mb-4">Tinggalkan Komentar</h4>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('comment.store', $post) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                        <input type="text" 
                               id="author_name" 
                               name="author_name" 
                               value="{{ old('author_name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('author_name') border-red-500 @enderror"
                               required>
                        @error('author_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="author_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" 
                               id="author_email" 
                               name="author_email" 
                               value="{{ old('author_email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('author_email') border-red-500 @enderror"
                               required>
                        @error('author_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Komentar *</label>
                    <textarea id="content" 
                              name="content" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('content') border-red-500 @enderror"
                              placeholder="Tulis komentar Anda..." 
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                    Kirim Komentar
                </button>
            </form>
        </div>

        <!-- Comments List -->
        @if($post->comments()->approved()->count() > 0)
        <div class="space-y-6">
            @foreach($post->comments()->approved()->latest()->get() as $comment)
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium">{{ substr($comment->author_name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h5 class="font-medium text-gray-900">{{ $comment->author_name }}</h5>
                            <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
        </div>
        @endif
    </section>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-8">Artikel Terkait</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPosts as $relatedPost)
            <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                @if($relatedPost->featured_image)
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                         alt="{{ $relatedPost->title }}"
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                @endif
                
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('post.show', $relatedPost) }}" class="hover:text-primary-600 transition-colors">
                            {{ $relatedPost->title }}
                        </a>
                    </h4>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $relatedPost->excerpt }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $relatedPost->published_at->format('d M Y') }}</span>
                        <a href="{{ route('post.show', $relatedPost) }}" 
                           class="text-primary-600 text-sm font-medium hover:text-primary-700 transition-colors">
                            Baca →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection