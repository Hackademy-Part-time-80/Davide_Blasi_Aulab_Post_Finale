@php($itemLabel = $route === 'categories' ? 'categoria' : 'tag')
<x-layout :title="(isset($item) ? 'Modifica ' : 'Aggiungi ') . $itemLabel . ' — The Aulab Post'" :error-targets="['name' => 'name']">
    <main id="main-content" class="home-page ui-page ui-form-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel" aria-labelledby="taxonomy-title">
                <header class="ui-page-intro">
                    <p class="home-kicker">Amministrazione</p>
                    <h1 class="home-form-title" id="taxonomy-title">{{ isset($item) ? 'Modifica' : 'Aggiungi' }} {{ $itemLabel }}</h1>
                </header>
                <form action="{{ isset($item) ? route($route . '.update', $item->id) : route($route . '.store') }}" method="POST" class="home-form">
                    @csrf
                    @if (isset($item)) @method('PATCH') @endif
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $item->name ?? '') }}" class="form-control @error('name') is-invalid @enderror"
                            maxlength="100" required autofocus @error('name') aria-invalid="true" aria-describedby="taxonomy-name-error" @enderror>
                        <x-field-error name="name" id="taxonomy-name-error" />
                    </div>
                    <div class="ui-form-actions">
                        <button type="submit" class="home-button">{{ isset($item) ? 'Salva modifiche' : 'Crea' }}</button>
                        <a href="{{ route($route . '.index') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>