@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Header -->
    <header class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Kategori: {{ $category->name }}
        </h1>
        <p class="text-gray-600">
            Menampilkan {{ $posts->count() }} artikel dalam kategori ini
        </p>
    </header>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
        <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
            @if($post->featured_image)
            <div class="h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}"
                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
            </div>
            @endif

            <div class="p-6">
                <a href="{{ route('category.show', $post->category) }}" 
                   class="inline-block bg-primary-100 text-primary-600 px-3 py-1 rounded-full text-xs font-medium mb-3 hover:bg-primary-200 transition-colors">
                    {{ $post->category->name }}
                </a>

                <h2 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                    <a href="{{ route('post.show', $post) }}" class="hover:text-primary-600 transition-colors">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ $post->excerpt }}
                </p>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>{{ $post->published_at->format('d M Y') }}</span>
                    <span>oleh {{ $post->user->name }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $posts->links() }}
    </div>

    @else
    <div class="text-center py-16 text-gray-500">
        <p>Belum ada artikel dalam kategori ini.</p>
    </div>
    @endif
</div>
@endsection