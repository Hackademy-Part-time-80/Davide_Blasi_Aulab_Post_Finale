<x-layout>
    <main class="home-page">
        <div class="home-container home-form-page home-form-page-wide">
            <section class="home-form-panel">
                <p class="home-kicker">The Aulab Post</p>
                <h1 class="home-form-title">{{ $article->exists ? 'Modifica articolo' : 'Scrivi un articolo' }}</h1>
                <p class="home-muted">Gli articoli inviati tornano in revisione prima della pubblicazione.</p>

                <form
                    action="{{ $article->exists ? route('articles.update', $article) : route('articles.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="home-form">
                    @csrf
                    @if ($article->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label for="title" class="form-label">Titolo</label>
                        <input id="title" name="title" type="text" value="{{ old('title', $article->title) }}" class="form-control" maxlength="255" required>
                    </div>

                    <div>
                        <label for="subtitle" class="form-label">Sottotitolo <span class="text-white-50">(facoltativo)</span></label>
                        <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $article->subtitle) }}" class="form-control" maxlength="255">
                    </div>

                    <div>
                        <label for="category_id" class="form-label">Categoria</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">Seleziona una categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $article->category_id) === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($categories->isEmpty())
                            <p class="home-form-help">Non ci sono categorie disponibili. Contatta un amministratore.</p>
                        @endif
                    </div>

                    <div>
                        <label for="body" class="form-label">Testo dell'articolo</label>
                        <textarea id="body" name="body" rows="12" class="form-control" required>{{ old('body', $article->body) }}</textarea>
                    </div>

                    <div>
                        <label for="cover_image" class="form-label">Immagine di copertina {{ $article->exists ? '(facoltativa)' : '' }}</label>
                        <input id="cover_image" name="cover_image" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp" @required(!$article->exists)>
                        <p class="home-form-help">Formati ammessi: JPG, PNG o WebP. Dimensione massima: 10 MB.</p>
                        @if ($article->cover_image)
                            <img class="home-form-current-cover" src="{{ Storage::url($article->cover_image) }}" alt="Copertina attuale">
                        @endif
                    </div>

                    <fieldset>
                        <legend class="form-label">Tag <span class="text-white-50">(facoltativi)</span></legend>
                        <div class="home-form-tags">
                            @php
                                $selectedTags = old('tags', $article->exists ? $article->tags->modelKeys() : []);
                            @endphp
                            @forelse ($tags as $tag)
                                <label class="home-form-check">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, $selectedTags))>
                                    <span>{{ $tag->name }}</span>
                                </label>
                            @empty
                                <p class="home-form-help mb-0">Non sono ancora disponibili tag.</p>
                            @endforelse
                        </div>
                    </fieldset>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="home-button">{{ $article->exists ? 'Salva modifiche' : 'Invia per la revisione' }}</button>
                        <a href="{{ $article->exists ? route('writer.dashboard') : route('homepage') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>