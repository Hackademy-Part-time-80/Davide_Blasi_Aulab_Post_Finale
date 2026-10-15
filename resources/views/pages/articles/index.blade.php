<x-layout title="Archivio articoli — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-archive-page" tabindex="-1">
        <div class="home-container home-archive">
            <header class="home-archive-header ui-page-intro">
                <div>
                    <p class="home-kicker">The Aulab Post</p>
                    <h1>Archivio articoli</h1>
                    <p class="home-muted">Esplora le storie pubblicate dalla community.</p>
                </div>

                <form action="{{ route('articles.index') }}" method="GET" class="home-archive-search" role="search">
                    <label for="article-search" class="visually-hidden">Cerca articoli</label>
                    <input
                        id="article-search"
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cerca articoli, categorie..."
                        class="form-control">
                    @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                    @endif
                    <button class="home-button" type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Cerca</button>
                </form>
            </header>

            @if ($category || $author)
            <div class="home-archive-filters" role="group" aria-label="Filtri attivi">
                <span>Filtri:</span>
                @if ($category)
                <a class="home-tag" href="{{ route('articles.index', array_filter(['q' => request('q'), 'author' => request('author')])) }}" aria-label="Rimuovi il filtro categoria: {{ $category->name }}">
                    Categoria: {{ $category->name }} <span aria-hidden="true">&times;</span>
                </a>
                @endif
                @if ($author)
                <a class="home-tag" href="{{ route('articles.index', array_filter(['q' => request('q'), 'category' => request('category')])) }}" aria-label="Rimuovi il filtro autore: {{ $author->name }}">
                    Autore: {{ $author->name }} <span aria-hidden="true">&times;</span>
                </a>
                @endif
            </div>
            @endif

            <div class="home-archive-summary">
                <h2 class="home-heading">
                    @if ($category)
                    {{ $category->name }}
                    @elseif ($author)
                    Articoli di {{ $author->name }}
                    @elseif (request('q'))
                    Risultati per “{{ request('q') }}”
                    @else
                    Tutti gli articoli
                    @endif
                </h2>
                <span class="home-muted">{{ $articles->total() }} {{ $articles->total() === 1 ? 'articolo' : 'articoli' }}</span>
            </div>

            <div class="row g-4 home-archive-grid">
                @forelse ($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <article class="home-archive-card">
                        <a class="home-archive-image" href="{{ route('articles.show', $article->id) }}" tabindex="-1" aria-hidden="true">
                            @if ($article->cover_image)
                            <img src="{{ Storage::url($article->cover_image) }}" alt="" loading="lazy" decoding="async">
                            @else
                            <span class="home-image-placeholder"><i class="fa-solid fa-book-open" aria-hidden="true"></i></span>
                            @endif
                        </a>
                        <div class="home-archive-card-body">
                            <div class="home-cat">{{ $article->category?->name ?? 'Articolo' }}</div>
                            <h2><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h2>
                            <p>{{ $article->subtitle ?: Str::limit($article->body, 150) }}</p>
                            <div class="home-archive-meta">
                                <span>{{ $article->user?->name ?? 'Autore' }}</span>
                                <time datetime="{{ $article->created_at->toDateString() }}">{{ $article->created_at->format('d/m/Y') }}</time>
                            </div>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12">
                    <div class="home-archive-empty">
                        <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                        <h2>Nessun articolo trovato</h2>
                        <p>Prova a modificare i termini di ricerca o rimuovere un filtro.</p>
                        <a class="home-button" href="{{ route('articles.index') }}">Mostra tutti gli articoli</a>
                    </div>
                </div>
                @endforelse
            </div>

            @if ($articles->hasPages())
            <div class="home-archive-pagination">
                {{ $articles->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </main>
</x-layout>