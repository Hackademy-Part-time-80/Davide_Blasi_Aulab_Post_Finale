<x-layout title="Feedback ricevuti — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-feedback-page" tabindex="-1">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header ui-page-intro">
                <div>
                    <p class="home-kicker">Amministrazione</p>
                    <h1>Feedback ricevuti</h1>
                </div>

                <span class="home-count">
                    {{ $feedbacks->total() }} messaggi
                </span>
            </header>

            <div class="home-dashboard-list">
                @forelse ($feedbacks as $feedback)
                <article class="home-dashboard-row ui-feedback-card">
                    <div class="home-dashboard-article">
                        <h2>{{ $feedback->name }}</h2>

                        <div class="ui-feedback-meta home-muted">
                            <span><i class="fa-regular fa-envelope" aria-hidden="true"></i> {{ $feedback->email }}</span>
                            <time datetime="{{ $feedback->created_at->toIso8601String() }}">{{ $feedback->created_at->format('d/m/Y H:i') }}</time>
                        </div>

                        <div class="home-article-body ui-feedback-message">
                            {{ $feedback->message }}
                        </div>
                    </div>
                </article>
                @empty
                <div class="home-archive-empty"><i class="fa-regular fa-envelope" aria-hidden="true"></i>
                    <h2>Non ci sono ancora feedback.</h2>
                </div>
                @endforelse
            </div>

            <div class="home-archive-pagination">
                {{ $feedbacks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>
</x-layout>