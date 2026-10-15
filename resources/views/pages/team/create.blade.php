<x-layout title="Lavora con noi — The Aulab Post" :error-targets="['requested_role_id' => 'requested_role_id', 'message' => 'message']">
    <main id="main-content" class="home-page ui-page ui-form-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel" aria-labelledby="team-form-title">
                <header class="ui-page-intro">
                    <p class="home-kicker">Partecipa</p>
                    <h1 class="home-form-title" id="team-form-title">Richiedi un ruolo</h1>
                    <p class="home-muted">Invia una richiesta per entrare nel team editoriale.</p>

                </header>
                <form action="{{ route('team.store') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="requested_role_id" class="form-label">Ruolo richiesto</label>
                        <select id="requested_role_id" name="requested_role_id"
                            class="form-select @error('requested_role_id') is-invalid @enderror" required
                            @error('requested_role_id') aria-invalid="true" aria-describedby="requested-role-error" @enderror>
                            <option value="">Seleziona un ruolo</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected((string) old('requested_role_id')===(string) $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('requested_role_id')
                        <div class="invalid-feedback" id="requested-role-error">{{ $message }}</div>
                        @enderror
                        @if ($roles->isEmpty())
                        <p class="home-form-help">Al momento non ci sono ruoli disponibili per la richiesta.</p>
                        @endif
                    </div>
                    <div>
                        <label for="message" class="form-label">Messaggio <span class="text-white-50">(facoltativo)</span></label>
                        <textarea id="message" name="message" rows="5"
                            class="form-control @error('message') is-invalid @enderror"
                            @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback" id="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="ui-form-actions">
                        <button type="submit" class="home-button" @disabled($roles->isEmpty())>Invia richiesta</button>
                        <a href="{{ route('homepage') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>