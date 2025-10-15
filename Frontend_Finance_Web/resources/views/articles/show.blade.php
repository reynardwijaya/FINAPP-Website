@extends('layouts.app')

@section('title', $article->title . ' - Finapp')

@section('header', 'Article Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Article Header -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden" data-aos="fade-up">
        @if($article->image_url)
            <div class="relative h-96">
                <img src="{{ $article->image_url }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
            </div>
        @endif
        <div class="p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                        {{ $article->category }}
                    </span>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-2"></i>
                        {{ $article->reading_time }} min read
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" onclick="shareArticle()">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" onclick="bookmarkArticle()">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $article->title }}</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-4">By {{ $article->author }} | {{ $article->created_at->format('M d, Y') }}</p>
            
            @if($article->tags)
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($article->formatted_tags as $tag)
                        <a href="{{ route('articles.index', ['tag' => $tag['slug']]) }}" 
                           class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            #{{ $tag['name'] }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="flex items-center space-x-4 mb-8">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->author }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Financial Expert</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8" data-aos="fade-up" data-aos-delay="100">
        <div class="prose dark:prose-invert max-w-none">
            {!! $article->content !!}
        </div>
    </div>

    <!-- Article Tags -->
    @if($article->tags)
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="fas fa-tags mr-2"></i>Article Tags
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach($article->formatted_tags as $tag)
                <a href="{{ route('articles.index', ['tag' => $tag['slug']]) }}" 
                   class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors">
                    #{{ $tag['name'] }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Related Articles -->
    @if($relatedArticles->isNotEmpty())
    <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-book text-indigo-500 mr-2"></i>
            Related Articles
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($relatedArticles as $related)
            <a href="{{ route('articles.show', $related) }}" 
               class="card bg-gray-50 dark:bg-gray-700 rounded-lg p-6 hover-scale">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                        {{ $related->category }}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $related->reading_time }} min read
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                    {{ $related->title }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">
                    {{ Str::limit(strip_tags($related->content), 100) }}
                </p>
                @if($related->tags)
                    <div class="flex flex-wrap gap-1 mb-2">
                        @foreach($related->formatted_tags->take(2) as $tag)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300">
                                #{{ $tag['name'] }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Share and Navigation -->
    <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="400">
        <a href="{{ route('articles.index') }}" 
           class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Articles
        </a>
        <div class="flex items-center space-x-4">
            <button onclick="shareArticle()" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                <i class="fas fa-share-alt mr-2"></i>
                Share Article
            </button>
            <button onclick="bookmarkArticle()" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                <i class="fas fa-bookmark mr-2"></i>
                Bookmark
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function shareArticle() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $article->title }}',
            text: 'Check out this article on Finapp',
            url: window.location.href,
        })
        .catch(console.error);
    } else {
        // Fallback for browsers that don't support the Web Share API
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = window.location.href;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('Link copied to clipboard!');
    }
}

function bookmarkArticle() {
    // Implement bookmark functionality
    alert('Bookmark feature coming soon!');
}
</script>
@endpush
@endsection 