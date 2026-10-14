<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page">
            <section class="home-form-panel">
                <p class="home-kicker">Partecipa</p>
                <h1 class="home-form-title">Richiedi un ruolo</h1>
                <p class="home-muted">Invia una richiesta per entrare nel team editoriale.</p>

                <form action="{{ route('team.store') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="requested_role_id" class="form-label">Ruolo richiesto</label>
                        <select id="requested_role_id" name="requested_role_id" class="form-select" required>
                            <option value="">Seleziona un ruolo</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected((string) old('requested_role_id') === (string) $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @if ($roles->isEmpty())
                            <p class="home-form-help">Al momento non ci sono ruoli disponibili per la richiesta.</p>
                        @endif
                    </div>
                    <div>
                        <label for="message" class="form-label">Messaggio <span class="text-white-50">(facoltativo)</span></label>
                        <textarea id="message" name="message" rows="5" class="form-control">{{ old('message') }}</textarea>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="home-button" @disabled($roles->isEmpty())>Invia richiesta</button>
                        <a href="{{ route('homepage') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>