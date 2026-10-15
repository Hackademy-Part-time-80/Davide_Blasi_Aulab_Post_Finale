<x-layout title="Amministrazione — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-admin-page" tabindex="-1">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header ui-page-intro">
                <div>
                    <p class="home-kicker">Amministrazione</p>
                    <h1>Dashboard</h1>
                    <p class="home-muted">Riepilogo editoriale e gestione degli account.</p>
                </div>
                <div class="home-dashboard-links">
                    <a href="{{ route('categories.index') }}" class="home-secondary-button">Categorie</a>
                    <a href="{{ route('tags.index') }}" class="home-secondary-button">Tag</a>
                    <a href="{{ route('review.index') }}" class="home-secondary-button">Revisione</a>
                </div>
            </header>

            <section class="home-admin-counts" aria-label="Conteggio articoli per stato">
                @foreach (['in_revisione' => 'In revisione', 'pubblicato' => 'Pubblicati', 'rifiutato' => 'Rifiutati'] as $status => $label)
                <div class="home-admin-count ui-stat-card ui-stat-{{ $status }}">
                    <span>{{ $label }}</span>
                    <strong>{{ $counts->get($status, 0) }}</strong>
                </div>
                @endforeach
            </section>

            <section class="home-admin-section" aria-labelledby="pending-team-title">
                <div class="home-section-head">
                    <h2 class="home-heading" id="pending-team-title">Richieste team in attesa</h2>
                    <span class="home-count">{{ $requests->count() }}</span>
                </div>
                <div class="home-dashboard-list">
                    @forelse ($requests as $teamRequest)
                    <article class="home-dashboard-row ui-request-card">
                        <div class="home-dashboard-article">
                            <h3>{{ $teamRequest->user?->name ?? 'Utente' }} <span class="home-muted">richiede</span> {{ $teamRequest->requestedRole?->name ?? 'un ruolo non disponibile' }}</h3>
                            @if ($teamRequest->message)
                            <p class="home-muted mb-0 ui-request-message">{{ $teamRequest->message }}</p>
                            @endif
                        </div>
                        <div class="home-dashboard-actions">
                            <form action="{{ route('team.resolve', ['teamRequest' => $teamRequest->id, 'decision' => 'approve']) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="home-button" aria-label="Approva richiesta di {{ $teamRequest->user?->name ?? 'Utente' }}">Approva</button>
                            </form>
                            <form action="{{ route('team.resolve', ['teamRequest' => $teamRequest->id, 'decision' => 'reject']) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="home-danger-button" aria-label="Rifiuta richiesta di {{ $teamRequest->user?->name ?? 'Utente' }}">Rifiuta</button>
                            </form>
                        </div>
                    </article>
                    @empty
                    <div class="home-archive-empty ui-empty-compact"><i class="fa-regular fa-circle-check" aria-hidden="true"></i>
                        <p class="home-muted mb-0">Non ci sono richieste in attesa.</p>
                    </div>
                    @endforelse
                </div>
            </section>

            <section class="home-admin-section" aria-labelledby="users-title">
                <div class="home-section-head">
                    <h2 class="home-heading" id="users-title">Utenti e ruoli</h2>
                    <span class="home-count">{{ $users->count() }} utenti</span>
                </div>
                <div class="home-table-wrap ui-users-table" role="region" aria-labelledby="users-title" tabindex="0">
                    <table class="table home-admin-table align-middle mb-0">
                        <caption class="visually-hidden">Utenti e ruoli. La tabella può essere scorsa orizzontalmente sui piccoli schermi.</caption>
                        <thead>
                            <tr>
                                <th scope="col">Utente</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ruolo</th>
                                <th scope="col">Aggiorna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <th scope="row" class="ui-user-name">{{ $user->name }} @if (auth()->user()?->is($user)) <span class="home-muted">(tu)</span> @endif</th>
                                <td>{{ $user->email }}</td>
                                <td><span class="home-status ui-role-badge">{{ $user->role?->name ?? 'Nessun ruolo' }}</span></td>
                                <td>
                                    @unless (auth()->user()?->is($user))
                                    <form action="{{ route('admin.users.role', $user) }}" method="POST" class="home-role-form">
                                        @csrf
                                        @method('PATCH')
                                        <label class="visually-hidden" for="role-{{ $user->id }}">Ruolo per {{ $user->name }}</label>
                                        <select id="role-{{ $user->id }}" name="role_id" class="form-select form-select-sm">
                                            <option value="">Nessun ruolo</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="home-secondary-button" type="submit" aria-label="Salva ruolo per {{ $user->name }}">Salva</button>
                                    </form>
                                    @else
                                    <span class="home-muted">Il tuo ruolo non è modificabile qui.</span>
                                    @endunless
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="home-muted">Nessun utente registrato.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</x-layout>