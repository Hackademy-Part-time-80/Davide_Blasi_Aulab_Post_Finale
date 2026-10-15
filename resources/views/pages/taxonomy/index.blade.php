<x-layout :title="$label . ' — The Aulab Post'">
    <main id="main-content" class="home-page ui-page ui-taxonomy-page" tabindex="-1">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header ui-page-intro">
                <div>
                    <p class="home-kicker">Amministrazione</p>
                    <h1>{{ $label }}</h1>
                    <p class="home-muted">Gestisci i valori disponibili agli articoli.</p>
                </div>
                <a href="{{ route($route . '.create') }}" class="home-button"><i class="fa-solid fa-plus" aria-hidden="true"></i> Aggiungi</a>
            </header>

            <div class="home-dashboard-list">
                @forelse ($items as $item)
                <article class="home-dashboard-row ui-taxonomy-card">
                    <div class="home-dashboard-article">
                        <h2>{{ $item->name }}</h2>
                        <p class="home-muted mb-0">{{ $item->articles_count }} {{ $item->articles_count === 1 ? 'articolo collegato' : 'articoli collegati' }}</p>
                    </div>
                    <div class="home-dashboard-actions">
                        <a href="{{ route($route . '.edit', $item->id) }}" class="home-secondary-button" aria-label="Modifica {{ $item->name }}"><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i> Modifica</a>
                        <form action="{{ route($route . '.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Eliminare questo elemento?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="home-danger-button" aria-label="Elimina {{ $item->name }}"><i class="fa-regular fa-trash-can" aria-hidden="true"></i> Elimina</button>
                        </form>
                    </div>
                </article>
                @empty
                <div class="home-archive-empty">
                    <i class="fa-solid fa-tags" aria-hidden="true"></i>
                    <h2>Nessun elemento presente</h2>
                    <p>Aggiungi il primo elemento per renderlo disponibile agli articoli.</p>
                    <a href="{{ route($route . '.create') }}" class="home-button">Aggiungi {{ strtolower($label) }}</a>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>