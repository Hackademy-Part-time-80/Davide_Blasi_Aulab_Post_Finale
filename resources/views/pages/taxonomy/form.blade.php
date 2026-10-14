<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page">
            <section class="home-form-panel">
                <p class="home-kicker">Amministrazione</p>
                <h1 class="home-form-title">{{ isset($item) ? 'Modifica' : 'Aggiungi' }} {{ strtolower($label) }}</h1>

                <form action="{{ isset($item) ? route($route . '.update', $item->id) : route($route . '.store') }}" method="POST" class="home-form">
                    @csrf
                    @if (isset($item))
                        @method('PATCH')
                    @endif
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $item->name ?? '') }}" class="form-control" maxlength="100" required autofocus>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="home-button">{{ isset($item) ? 'Salva modifiche' : 'Crea' }}</button>
                        <a href="{{ route($route . '.index') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>