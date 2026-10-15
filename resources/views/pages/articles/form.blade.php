<x-layout :title="($article->exists ? 'Modifica articolo' : 'Scrivi un articolo') . ' — The Aulab Post'"
    :error-targets="['title' => 'title', 'subtitle' => 'subtitle', 'body' => 'body', 'category_id' => 'category_id', 'cover_image' => 'cover_image', 'tags' => 'article-tags']">
    <main id="main-content" class="home-page ui-page ui-form-page" tabindex="-1">
        <div class="home-container home-form-page home-form-page-wide">
            <section class="home-form-panel" aria-labelledby="article-form-title">
                <header class="ui-page-intro">
                    <p class="home-kicker">The Aulab Post</p>
                    <h1 class="home-form-title" id="article-form-title">{{ $article->exists ? 'Modifica articolo' : 'Scrivi un articolo' }}</h1>
                    <p class="home-muted">Gli articoli inviati tornano in revisione prima della pubblicazione.</p>
                </header>
                <form action="{{ $article->exists ? route('articles.update', $article) : route('articles.store') }}"
                    method="POST" enctype="multipart/form-data" class="home-form">
                    @csrf
                    @if ($article->exists) @method('PUT') @endif
                    <fieldset class="ui-form-section">
                        <legend class="ui-form-section-title">Contenuto dell'articolo</legend>
                        <div>
                            <label for="title" class="form-label">Titolo</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $article->title) }}"
                                class="form-control @error('title') is-invalid @enderror" maxlength="255" required
                                @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
                            <x-field-error name="title" id="title-error" />
                        </div>
                        <div>
                            <label for="subtitle" class="form-label">Sottotitolo <span class="text-white-50">(facoltativo)</span></label>
                            <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $article->subtitle) }}"
                                class="form-control @error('subtitle') is-invalid @enderror" maxlength="255"
                                @error('subtitle') aria-invalid="true" aria-describedby="subtitle-error" @enderror>
                            <x-field-error name="subtitle" id="subtitle-error" />
                        </div>
                        <div>
                            <label for="body" class="form-label">Testo dell'articolo</label>
                            <textarea id="body" name="body" rows="12" class="form-control @error('body') is-invalid @enderror" required
                                @error('body') aria-invalid="true" aria-describedby="body-error" @enderror>{{ old('body', $article->body) }}</textarea>
                            <x-field-error name="body" id="body-error" />
                        </div>
                    </fieldset>
                    <fieldset class="ui-form-section">
                        <legend class="ui-form-section-title">Categoria e tag</legend>
                        <div>
                            <label for="category_id" class="form-label">Categoria</label>
                            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required
                                @error('category_id') aria-invalid="true" aria-describedby="category-error" @enderror>
                                <option value="">Seleziona una categoria</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $article->category_id) === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-field-error name="category_id" id="category-error" />
                            @if ($categories->isEmpty())<p class="home-form-help">Non ci sono categorie disponibili. Contatta un amministratore.</p>@endif
                        </div>
                        <fieldset id="article-tags" tabindex="-1" @if ($errors->has('tags') || $errors->has('tags.*')) aria-describedby="tags-error" @endif>
                            <legend class="form-label">Tag <span class="text-white-50">(facoltativi)</span></legend>
                            <div class="home-form-tags">
                                @php($selectedTags = old('tags', $article->exists ? $article->tags->modelKeys() : []))
                                @forelse ($tags as $tag)
                                <label class="home-form-check" for="tag-{{ $tag->id }}">
                                    <input id="tag-{{ $tag->id }}" type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, $selectedTags))>
                                    <span>{{ $tag->name }}</span>
                                </label>
                                @empty
                                <p class="home-form-help mb-0">Non sono ancora disponibili tag.</p>
                                @endforelse
                            </div>
                            <x-field-error name="tags" id="tags-error" />
                        </fieldset>
                    </fieldset>
                    <fieldset class="ui-form-section">
                        <legend class="ui-form-section-title">Copertina</legend>
                        <div>
                            <label for="cover_image" class="form-label">Immagine di copertina {{ $article->exists ? '(facoltativa)' : '' }}</label>
                            <input id="cover_image" name="cover_image" type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp" @required(!$article->exists)
                            aria-describedby="cover-help{{ $errors->has('cover_image') ? ' cover-error' : '' }}" @error('cover_image') aria-invalid="true" @enderror>
                            <p class="home-form-help" id="cover-help">Formati ammessi: JPG, PNG o WebP. Dimensione massima: 10 MB.</p>
                            <x-field-error name="cover_image" id="cover-error" />
                            @if ($article->cover_image)
                            <img class="home-form-current-cover" src="{{ Storage::url($article->cover_image) }}" alt="Copertina attuale">
                            @endif
                        </div>
                    </fieldset>
                    <div class="ui-form-actions">
                        <button type="submit" class="home-button">{{ $article->exists ? 'Salva modifiche' : 'Invia per la revisione' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                        <a href="{{ $article->exists ? route('writer.dashboard') : route('homepage') }}" class="home-secondary-button">Annulla</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-layout>