<x-layout>
    <main class="home-page">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header">
                <div>
                    <p class="home-kicker">Area autore</p>
                    <h1>I miei articoli</h1>
                    <p class="home-muted">Gestisci le bozze inviate e controlla lo stato di revisione.</p>
                </div>
                <a href="{{ route('articles.create') }}" class="home-button"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Scrivi un articolo</a>
            </header>

            <div class="home-dashboard-list">
                @forelse ($articles as $article)
                    <article class="home-dashboard-row">
                        <div class="home-dashboard-article">
                            <h2><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h2>
                            <p class="home-muted mb-0">{{ $article->category?->name ?? 'Senza categoria' }} <span aria-hidden="true">&middot;</span> {{ $article->created_at->format('d/m/Y') }}</p>
                        </div>
                        <span class="home-status home-status-{{ $article->status }}">
                            @switch($article->status)
                                @case('pubblicato') Pubblicato @break
                                @case('rifiutato') Rifiutato @break
                                @default In revisione
                            @endswitch
                        </span>
                        <div class="home-dashboard-actions">
                            <a href="{{ route('articles.edit', $article) }}" class="home-secondary-button">Modifica</a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Eliminare questo articolo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="home-danger-button">Elimina</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="home-archive-empty">
                        <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                        <h2>Non hai ancora inviato articoli</h2>
                        <p>Quando invierai un articolo, qui potrai seguirne lo stato.</p>
                        <a href="{{ route('articles.create') }}" class="home-button">Scrivi il primo articolo</a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>