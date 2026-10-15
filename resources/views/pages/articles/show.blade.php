<x-layout :title="$article->title . ' — The Aulab Post'">
    <main id="main-content" class="home-page ui-page ui-reader-page" tabindex="-1">
        <article class="home-container home-article-detail ui-reader-layout">
            <a class="home-back-link" href="{{ route('articles.index') }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Torna agli articoli</a>
            <header class="home-detail-header ui-page-intro">
                @if ($article->category)
                <a class="home-cat" href="{{ route('articles.index', ['category' => $article->category->id]) }}">{{ $article->category->name }}</a>
                @else
                <span class="home-cat">Articolo</span>
                @endif
                <h1>{{ $article->title }}</h1>
                @if ($article->subtitle)<p class="home-detail-subtitle">{{ $article->subtitle }}</p>@endif
                <div class="home-archive-meta ui-reader-meta">
                    <span><i class="fa-regular fa-user" aria-hidden="true"></i> {{ $article->user?->name ?? 'Autore' }}</span>
                    <time datetime="{{ $article->created_at->toDateString() }}"><i class="fa-regular fa-calendar" aria-hidden="true"></i> {{ $article->created_at->format('d/m/Y') }}</time>
                </div>
            </header>
            @if ($article->cover_image)
            <img class="home-detail-cover" src="{{ Storage::url($article->cover_image) }}" alt="Copertina: {{ $article->title }}" fetchpriority="high" decoding="async">
            @endif
            <div class="home-article-body ui-reader-content">{{ $article->body }}</div>
            @if ($article->tags->isNotEmpty())
            <footer class="home-detail-tags" aria-label="Tag articolo">
                <i class="fa-solid fa-tags" aria-hidden="true"></i>
                @foreach ($article->tags as $tag)<span class="home-tag">{{ $tag->name }}</span>@endforeach
            </footer>
            @endif
        </article>
    </main>
</x-layout>