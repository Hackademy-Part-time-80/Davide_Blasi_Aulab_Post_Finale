<x-layout>
    <main class="home-page">
        <article class="home-container home-article-detail">
            <a class="home-back-link" href="{{ route('articles.index') }}"><span aria-hidden="true">&larr;</span> Torna agli articoli</a>

            @if ($article->cover_image)
                <img class="home-detail-cover" src="{{ Storage::url($article->cover_image) }}" alt="Copertina: {{ $article->title }}">
            @endif

            <header class="home-detail-header">
                <div class="home-cat">{{ $article->category?->name ?? 'Articolo' }}</div>
                <h1>{{ $article->title }}</h1>
                @if ($article->subtitle)
                    <p class="home-detail-subtitle">{{ $article->subtitle }}</p>
                @endif
                <div class="home-archive-meta">
                    <span>{{ $article->user?->name ?? 'Autore' }}</span>
                    <time datetime="{{ $article->created_at->toDateString() }}">{{ $article->created_at->format('d/m/Y') }}</time>
                </div>
            </header>

            <div class="home-article-body">{{ $article->body }}</div>

            @if ($article->tags->isNotEmpty())
                <footer class="home-detail-tags" aria-label="Tag articolo">
                    @foreach ($article->tags as $tag)
                        <span class="home-tag">{{ $tag->name }}</span>
                    @endforeach
                </footer>
            @endif
        </article>
    </main>
</x-layout>