<x-layout title="Articoli da revisionare — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-review-page" tabindex="-1">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header ui-page-intro">
                <div>
                    <p class="home-kicker">Redazione</p>
                    <h1>Articoli da revisionare</h1>
                    <p class="home-muted">Valuta le proposte in attesa di revisione.</p>
                </div>
                <span class="home-count">{{ $articles->count() }} in attesa</span>
            </header>

            <div class="home-review-list">
                @forelse ($articles as $article)
                <article class="home-review-item ui-review-card">
                    <div class="home-review-copy">
                        <div class="home-cat">{{ $article->category?->name ?? 'Senza categoria' }}</div>
                        <h2>{{ $article->title }}</h2>
                        @if ($article->subtitle)
                        <p class="home-review-subtitle">{{ $article->subtitle }}</p>
                        @endif
                        <p class="home-review-body">{{ $article->body }}</p>
                        <div class="home-mini-meta ui-review-byline"><i class="fa-regular fa-user" aria-hidden="true"></i> {{ $article->user?->name ?? 'Autore' }} <span aria-hidden="true">&middot;</span> <time datetime="{{ $article->created_at->toIso8601String() }}">{{ $article->created_at->format('d/m/Y H:i') }}</time></div>
                    </div>
                    <div class="home-review-actions">
                        <form action="{{ route('review.resolve', ['article' => $article->id, 'decision' => 'approve']) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="home-button" aria-label="Approva articolo: {{ $article->title }}">Approva</button>
                        </form>
                        <form action="{{ route('review.resolve', ['article' => $article->id, 'decision' => 'reject']) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="home-danger-button" aria-label="Rifiuta articolo: {{ $article->title }}">Rifiuta</button>
                        </form>
                    </div>
                </article>
                @empty
                <div class="home-archive-empty">
                    <i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                    <h2>Nessun articolo in attesa</h2>
                    <p>La coda di revisione è aggiornata.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>