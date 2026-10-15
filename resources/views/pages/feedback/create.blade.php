<x-layout title="Lascia un feedback — The Aulab Post" :error-targets="['name' => 'feedback-name', 'email' => 'feedback-email', 'message' => 'feedback-message']">
    <main id="main-content" class="home-page ui-page ui-form-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel" aria-labelledby="feedback-title">
                <header class="ui-page-intro">
                    <span class="ui-page-icon" aria-hidden="true"><i class="fa-regular fa-comment-dots"></i></span>
                    <p class="home-kicker">La tua opinione conta</p>
                    <h1 class="home-form-title" id="feedback-title">Lascia un feedback</h1>
                    <p class="home-muted">Hai un suggerimento o hai riscontrato un problema? Scrivici: il messaggio sarà visibile agli amministratori.</p>
                </header>
                <form action="{{ route('feedback.store') }}" method="POST" class="home-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="feedback-name" class="form-label">Nome</label>
                            <input id="feedback-name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()?->name) }}" autocomplete="name" maxlength="100" required
                                @error('name') aria-invalid="true" aria-describedby="feedback-name-error" @enderror>
                            <x-field-error name="name" id="feedback-name-error" />
                        </div>
                        <div class="col-md-6">
                            <label for="feedback-email" class="form-label">Email</label>
                            <input id="feedback-email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', auth()->user()?->email) }}" autocomplete="email" maxlength="255" required
                                @error('email') aria-invalid="true" aria-describedby="feedback-email-error" @enderror>
                            <x-field-error name="email" id="feedback-email-error" />
                        </div>
                    </div>
                    <div>
                        <label for="feedback-message" class="form-label">Messaggio</label>
                        <textarea id="feedback-message" name="message" class="form-control @error('message') is-invalid @enderror" rows="7" minlength="10" maxlength="3000" required
                            aria-describedby="feedback-message-help{{ $errors->has('message') ? ' feedback-message-error' : '' }}" @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                        <p class="home-form-help" id="feedback-message-help">Da 10 a 3.000 caratteri. Non inserire password o dati sensibili.</p>
                        <x-field-error name="message" id="feedback-message-error" />
                    </div>
                    <div class="ui-form-actions"><button type="submit" class="home-button">Invia feedback <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
                </form>
            </section>
        </div>
    </main>
</x-layout>