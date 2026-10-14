<x-layout>
    <main class="home-page">
        <div class="home-container home-dashboard">
            <header class="home-dashboard-header">
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
                <article class="home-dashboard-row">
                    <div class="home-dashboard-article">
                        <h2>{{ $feedback->name }}</h2>

                        <p class="home-muted">
                            {{ $feedback->email }}
                            &middot;
                            {{ $feedback->created_at->format('d/m/Y H:i') }}
                        </p>

                        <div class="home-article-body">
                            {{ $feedback->message }}
                        </div>
                    </div>
                </article>
                @empty
                <p class="home-muted">
                    Non ci sono ancora feedback.
                </p>
                @endforelse
            </div>

            <div class="home-archive-pagination">
                {{ $feedbacks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>
</x-layout>