<x-layout title="Crea articolo — The Aulab Post">
    <main id="main-content" class="home-page ui-page ui-form-page" tabindex="-1">
        <div class="home-container home-form-page">
            <section class="home-form-panel" aria-labelledby="legacy-create-title">
                <header class="ui-page-intro">
                    <p class="home-kicker">The Aulab Post</p>
                    <h1 class="home-form-title" id="legacy-create-title">Crea articolo</h1>
                </header>
                <form action="" method="post" class="home-form">
                    @csrf
                    <div>
                        <label for="legacy-title" class="form-label">Titolo</label>
                        <input class="form-control" type="text" name="name" id="legacy-title">
                    </div>
                    <div class="ui-form-actions"><button type="submit" class="home-button">Salva</button></div>
                </form>
            </section>
        </div>
    </main>
</x-layout>