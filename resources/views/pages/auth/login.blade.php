<x-layout title="Accedi — The Aulab Post" :error-targets="['email' => 'email', 'password' => 'password']">
    <main id="main-content" class="home-page ui-page ui-form-page ui-auth-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel ui-auth-panel" aria-labelledby="login-title">
                <header class="ui-page-intro">
                    <span class="ui-page-icon" aria-hidden="true"><i class="fa-solid fa-right-to-bracket"></i></span>
                    <p class="home-kicker">Bentornato</p>
                    <h1 class="home-form-title" id="login-title">Accedi</h1>
                    <p class="home-muted">Accedi al tuo account per continuare.</p>
                </header>
                <form action="{{ route('login') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        <x-field-error name="email" id="email-error" />
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required
                            @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                        <x-field-error name="password" id="password-error" />
                    </div>
                    <div class="ui-form-actions"><button type="submit" class="home-button">Accedi <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
                </form>
                <p class="home-form-alternative">Non hai ancora un account? <a href="{{ route('register') }}">Registrati</a></p>
            </section>
        </div>
    </main>
</x-layout>