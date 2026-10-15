<x-layout title="Registrati — The Aulab Post" :error-targets="['name' => 'name', 'email' => 'email', 'password' => 'password', 'password_confirmation' => 'password_confirmation']">
    <main id="main-content" class="home-page ui-page ui-form-page ui-auth-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel ui-auth-panel" aria-labelledby="register-title">
                <header class="ui-page-intro">
                    <span class="ui-page-icon" aria-hidden="true"><i class="fa-solid fa-user-plus"></i></span>
                    <p class="home-kicker">Unisciti alla community</p>
                    <h1 class="home-form-title" id="register-title">Crea il tuo account</h1>
                    <p class="home-muted">Registrati per partecipare a The Aulab Post.</p>
                </header>
                <form action="{{ route('register') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                            autocomplete="name" maxlength="255" required autofocus @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        <x-field-error name="name" id="name-error" />
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror"
                            autocomplete="email" maxlength="255" required @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        <x-field-error name="email" id="email-error" />
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            autocomplete="new-password" minlength="8" required aria-describedby="password-help{{ $errors->has('password') ? ' password-error' : '' }}"
                            @error('password') aria-invalid="true" @enderror>
                        <p class="home-form-help" id="password-help">Almeno 8 caratteri.</p>
                        <x-field-error name="password" id="password-error" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Conferma password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            autocomplete="new-password" minlength="8" required @error('password_confirmation') aria-invalid="true" aria-describedby="password-confirmation-error" @enderror>
                        <x-field-error name="password_confirmation" id="password-confirmation-error" />
                    </div>
                    <div class="ui-form-actions"><button type="submit" class="home-button">Crea account <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
                </form>
                <p class="home-form-alternative">Hai già un account? <a href="{{ route('login') }}">Accedi</a></p>
            </section>
        </div>
    </main>
</x-layout>