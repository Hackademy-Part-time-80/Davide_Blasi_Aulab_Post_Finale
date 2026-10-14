<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page">
            <section class="home-form-panel">
                <p class="home-kicker">Bentornato</p>
                <h1 class="home-form-title">Accedi</h1>
                <p class="home-muted">Accedi al tuo account per continuare.</p>

                <form action="{{ route('login') }}" method="POST" class="home-form">
                    @csrf
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" autocomplete="email" required autofocus>
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="home-button">Accedi</button>
                </form>

                <p class="home-form-alternative">Non hai ancora un account? <a href="{{ route('register') }}">Registrati</a></p>
            </section>
        </div>
    </main>
</x-layout>