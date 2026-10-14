<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page">
            <section class="home-form-panel">
                <p class="home-kicker">Unisciti alla community</p>
                <h1 class="home-form-title">Crea il tuo account</h1>
                <p class="home-muted">Registrati per partecipare a The Aulab Post.</p>

                <form action="{{ route('register') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control" autocomplete="name" maxlength="255" required autofocus>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" autocomplete="email" maxlength="255" required>
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" minlength="8" required>
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Conferma password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" minlength="8" required>
                    </div>
                    <button type="submit" class="home-button">Crea account</button>
                </form>

                <p class="home-form-alternative">Hai già un account? <a href="{{ route('login') }}">Accedi</a></p>
            </section>
        </div>
    </main>
</x-layout>