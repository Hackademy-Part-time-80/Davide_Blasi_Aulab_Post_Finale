<x-layout title="Richieste di ingresso nel team — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-team-page" tabindex="-1">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header ui-page-intro">
                <div>
                    <p class="home-kicker">Amministrazione</p>
                    <h1>Richieste di ingresso nel team</h1>
                </div>
                <span class="home-count">{{ $requests->count() }} in attesa</span>
            </header>

            <div class="home-dashboard-list">
                @forelse ($requests as $teamRequest)
                <article class="home-dashboard-row ui-request-card">
                    <div class="home-dashboard-article">
                        <h2>{{ $teamRequest->user?->name ?? 'Utente' }} <span class="home-muted">richiede</span> {{ $teamRequest->requestedRole?->name ?? 'un ruolo non disponibile' }}</h2>
                        @if ($teamRequest->message)
                        <p class="home-muted mb-0 ui-request-message">{{ $teamRequest->message }}</p>
                        @endif
                    </div>
                    <div class="home-dashboard-actions">
                        @foreach (['approve' => 'Approva', 'reject' => 'Rifiuta'] as $decision => $label)
                        <form action="{{ route('team.resolve', ['teamRequest' => $teamRequest->id, 'decision' => $decision]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="{{ $decision === 'approve' ? 'home-button' : 'home-danger-button' }}" aria-label="{{ $label }} richiesta di {{ $teamRequest->user?->name ?? 'Utente' }}">{{ $label }}</button>
                        </form>
                        @endforeach
                    </div>
                </article>
                @empty
                <div class="home-archive-empty"><i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                    <h2>Nessuna richiesta in attesa</h2>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>