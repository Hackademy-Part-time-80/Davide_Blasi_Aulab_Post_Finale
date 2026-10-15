<x-layout title="The Aulab Post — Storie e idee dalla community">
    @php
    $featuredArticle = $articles->first();
    $sideArticles = $articles->skip(1)->take(3);
    $categories = $articles->pluck('category')->filter()->unique('id');
    $latestArticles = $articles->skip(4);
    $authors = $articles->pluck('user')->filter()->unique('id')->take(5);
    @endphp

    <main id="main-content" class="home-page" tabindex="-1">
        <div class="home-container">
            <section class="home-hero-wrap" aria-label="Articolo in evidenza e articoli recenti">
                <div class="home-hero-grid">
                    @if ($featuredArticle)
                    <article class="home-hero">
                        @if ($featuredArticle->cover_image)
                        <img class="home-hero-image" src="{{ Storage::url($featuredArticle->cover_image) }}" alt="Copertina: {{ $featuredArticle->title }}" fetchpriority="high" decoding="async">
                        @endif
                        <div class="home-hero-content">
                            <div class="home-kicker">{{ $featuredArticle->category?->name ?? 'In evidenza' }}</div>
                            <h1>{{ $featuredArticle->title }}</h1>
                            <p>{{ $featuredArticle->subtitle ?: Str::limit($featuredArticle->body, 180) }}</p>
                            <div class="home-meta">
                                @if ($featuredArticle->user)
                                <span>{{ $featuredArticle->user->name }}</span>
                                <span aria-hidden="true">&middot;</span>
                                @endif
                                <time datetime="{{ $featuredArticle->created_at->toDateString() }}">{{ $featuredArticle->created_at->format('d M Y') }}</time>
                                <a class="home-read" href="{{ route('articles.show', $featuredArticle->id) }}">Leggi l'articolo <span aria-hidden="true">&rarr;</span></a>
                            </div>
                        </div>
                    </article>
                    @else
                    <div class="home-hero home-hero-empty">
                        <div class="home-hero-content">
                            <div class="home-kicker">The Aulab Post</div>
                            <h1>Storie e idee dalla community.</h1>
                            <p>Gli articoli pubblicati appariranno qui. Nel frattempo puoi esplorare l'archivio.</p>
                            <a class="home-button" href="{{ route('articles.index') }}">Esplora gli articoli <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                    @endif

                    <aside class="home-side-column" aria-labelledby="home-recent-title">
                        <div class="home-section-head">
                            <h2 class="home-heading" id="home-recent-title">Ultimi articoli</h2>
                            <a class="home-view" href="{{ route('articles.index') }}">Vedi tutti <span aria-hidden="true">&rarr;</span></a>
                        </div>

                        @forelse ($sideArticles as $article)
                        <article class="home-mini">
                            <a href="{{ route('articles.show', $article->id) }}" class="home-mini-image-link" tabindex="-1" aria-hidden="true">
                                @if ($article->cover_image)
                                <img src="{{ Storage::url($article->cover_image) }}" alt="" loading="lazy" decoding="async">
                                @else
                                <span class="home-image-placeholder"><i class="fa-solid fa-book-open"></i></span>
                                @endif
                            </a>
                            <div>
                                <div class="home-cat">{{ $article->category?->name ?? 'Articolo' }}</div>
                                <h3><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h3>
                                <div class="home-mini-meta">
                                    {{ $article->user?->name }}@if ($article->user) &nbsp;&middot;&nbsp; @endif{{ $article->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </article>
                        @empty
                        <p class="home-muted home-empty-note">Non ci sono altri articoli recenti.</p>
                        @endforelse
                    </aside>
                </div>
            </section>

            @if ($categories->isNotEmpty())
            <section class="home-section" aria-labelledby="home-categories-title">
                <div class="home-section-head">
                    <h2 class="home-heading" id="home-categories-title">Esplora per categoria</h2>
                </div>
                <div class="home-category-grid">
                    @foreach ($categories as $category)
                    <a class="home-category" href="{{ route('articles.index', ['category' => $category->id]) }}">
                        <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                        <span>{{ $category->name }}</span>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            <section class="home-content-grid" aria-labelledby="home-latest-title">
                <div>
                    <div class="home-section-head">
                        <h2 class="home-heading" id="home-latest-title">Da non perdere</h2>
                        <a class="home-view" href="{{ route('articles.index') }}">Vai all'archivio <span aria-hidden="true">&rarr;</span></a>
                    </div>

                    <div class="home-latest-list">
                        @forelse ($latestArticles as $article)
                        <article class="home-article-row">
                            <a class="home-row-image" href="{{ route('articles.show', $article->id) }}" tabindex="-1" aria-hidden="true">
                                @if ($article->cover_image)
                                <img src="{{ Storage::url($article->cover_image) }}" alt="" loading="lazy" decoding="async">
                                @else
                                <span class="home-image-placeholder"><i class="fa-solid fa-book-open"></i></span>
                                @endif
                            </a>
                            <div class="home-row-body">
                                <div class="home-cat">{{ $article->category?->name ?? 'Articolo' }}</div>
                                <h3><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h3>
                                <p>{{ $article->subtitle ?: Str::limit($article->body, 120) }}</p>
                                <div class="home-mini-meta">
                                    {{ $article->user?->name }}@if ($article->user) &nbsp;&middot;&nbsp; @endif{{ $article->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </article>
                        @empty
                        <p class="home-muted">Altri articoli saranno disponibili qui dopo le prossime pubblicazioni.</p>
                        @endforelse
                    </div>
                </div>

                <aside class="home-sidebar" aria-label="Esplora il sito">
                    <section class="home-promo">
                        <h2>Continua a leggere</h2>
                        <p>Scopri tutti gli articoli pubblicati dalla community.</p>
                        <a class="home-dark-button" href="{{ route('articles.index') }}">Apri l'archivio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </section>

                    @if ($authors->isNotEmpty())
                    <section class="home-panel" aria-labelledby="home-authors-title">
                        <h2 class="home-panel-title" id="home-authors-title"><i class="fa-regular fa-user" aria-hidden="true"></i> Autori recenti</h2>
                        <div class="home-tags">
                            @foreach ($authors as $author)
                            <a class="home-tag" href="{{ route('articles.index', ['author' => $author->id]) }}">{{ $author->name }}</a>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </aside>
            </section>
        </div>
    </main>

    <footer class="home-footer">
        <div class="home-container home-footer-inner">
            <div>
                <div class="home-footer-logo">The Aulab <span>Post</span></div>
                <div class="home-footer-sub">Informazione, formazione, innovazione.</div>
            </div>
            <nav class="home-footer-links" aria-label="Navigazione footer">
                <a href="{{ route('homepage') }}">Home</a>
                <a href="{{ route('articles.index') }}">Articoli</a>
            </nav>
            <span class="home-copy">&copy; {{ date('Y') }} The Aulab Post</span>
        </div>
    </footer>

</x-layout>