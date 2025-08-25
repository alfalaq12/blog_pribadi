@extends('layouts.app')

@section('content')
<!-- Hero Section -->
@if($featuredPost)
<section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-block bg-white bg-opacity-20 rounded-full px-4 py-2 text-sm font-medium mb-4">
                    Featured Post
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    {{ $featuredPost->title }}
                </h1>
                <p class="text-xl mb-8 text-primary-100 leading-relaxed">
                    {{ $featuredPost->excerpt }}
                </p>
                <div class="flex items-center space-x-6 mb-8">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <span>{{ $featuredPost->user->name }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v14a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $featuredPost->published_at->format('d M Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('post.show', $featuredPost) }}" 
                   class="inline-flex items-center bg-white text-primary-600 px-8 py-4 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                    Baca Selengkapnya
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            
            @if($featuredPost->featured_image)
            <div class="relative">
                <img src="{{ asset('storage/' . $featuredPost->featured_image) }}" 
                     alt="{{ $featuredPost->title }}"
                     class="rounded-2xl shadow-2xl w-full h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black bg-opacity-20 rounded-2xl"></div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Latest Posts -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Latest Posts</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Temukan artikel-artikel terbaru tentang berbagai topik menarik
            </p>
        </div>

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($posts as $post)
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                @if($post->featured_image)
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $post->category->name }}
                        </span>
                    </div>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
                        <span>{{ $post->user->name }}</span>
                        <span>•</span>
                        <span>{{ $post->published_at->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                        <a href="{{ route('post.show', $post) }}" class="hover:text-primary-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $post->excerpt }}
                    </p>
                    
                    <a href="{{ route('post.show', $post) }}" 
                       class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                        Read More
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-4 text-xl font-medium text-gray-900">Belum ada post</h3>
            <p class="mt-2 text-gray-500">Mulai menulis post pertama Anda!</p>
        </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Browse by Category</h2>
            <p class="text-xl text-gray-600">Jelajahi artikel berdasarkan kategori yang Anda minati</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('category.show', $category) }}" 
               class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                        {{ $category->name }}
                    </h3>
                    <span class="bg-primary-100 text-primary-600 text-sm font-medium px-2 py-1 rounded-full">
                        {{ $category->posts_count }}
                    </span>
                </div>
                @if($category->description)
                <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection