<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page">
            <section class="home-form-panel">
                <p class="home-kicker">La tua opinione conta</p>

                <h1 class="home-form-title">Lascia un feedback</h1>

                <p class="home-muted">
                    Hai un suggerimento o hai riscontrato un problema?
                    Scrivici: il messaggio sarà visibile agli amministratori.
                </p>

                <form action="{{ route('feedback.store') }}"
                    method="POST"
                    class="home-form">
                    @csrf

                    <div>
                        <label for="feedback-name" class="form-label">
                            Nome
                        </label>

                        <input id="feedback-name"
                            name="name"
                            type="text"
                            class="form-control"
                            value="{{ old('name', auth()->user()?->name) }}"
                            autocomplete="name"
                            maxlength="100"
                            required>
                    </div>

                    <div>
                        <label for="feedback-email" class="form-label">
                            Email
                        </label>

                        <input id="feedback-email"
                            name="email"
                            type="email"
                            class="form-control"
                            value="{{ old('email', auth()->user()?->email) }}"
                            autocomplete="email"
                            maxlength="255"
                            required>
                    </div>

                    <div>
                        <label for="feedback-message" class="form-label">
                            Messaggio
                        </label>

                        <textarea id="feedback-message"
                            name="message"
                            class="form-control"
                            rows="6"
                            minlength="10"
                            maxlength="3000"
                            required>{{ old('message') }}</textarea>

                        <p class="home-form-help">
                            Da 10 a 3.000 caratteri.
                            Non inserire password o dati sensibili.
                        </p>
                    </div>

                    <button type="submit" class="home-button">
                        Invia feedback
                    </button>
                </form>
            </section>
        </div>
    </main>
</x-layout>