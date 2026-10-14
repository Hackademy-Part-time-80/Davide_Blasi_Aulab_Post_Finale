<x-layout>
    <main class="home-page">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header">
                <div>
                    <p class="home-kicker">Amministrazione</p>
                    <h1>{{ $label }}</h1>
                    <p class="home-muted">Gestisci i valori disponibili agli articoli.</p>
                </div>
                <a href="{{ route($route . '.create') }}" class="home-button"><i class="fa-solid fa-plus" aria-hidden="true"></i> Aggiungi</a>
            </header>

            <div class="home-dashboard-list">
                @forelse ($items as $item)
                    <article class="home-dashboard-row">
                        <div class="home-dashboard-article">
                            <h2>{{ $item->name }}</h2>
                            <p class="home-muted mb-0">{{ $item->articles_count }} {{ $item->articles_count === 1 ? 'articolo collegato' : 'articoli collegati' }}</p>
                        </div>
                        <div class="home-dashboard-actions">
                            <a href="{{ route($route . '.edit', $item->id) }}" class="home-secondary-button">Modifica</a>
                            <form action="{{ route($route . '.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Eliminare questo elemento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="home-danger-button">Elimina</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="home-archive-empty">
                        <h2>Nessun elemento presente</h2>
                        <p>Aggiungi il primo elemento per renderlo disponibile agli articoli.</p>
                        <a href="{{ route($route . '.create') }}" class="home-button">Aggiungi {{ strtolower($label) }}</a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>