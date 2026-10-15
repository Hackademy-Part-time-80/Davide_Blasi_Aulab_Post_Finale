<nav class="navbar navbar-expand-xxl navbar-dark bg-black sticky-top" aria-label="Navigazione principale">

    <div class="home-container navbar-shell">

        <a href="{{ route('homepage') }}"
            class="navbar-brand d-flex align-items-center gap-2">

            {{ $slot }}

            <i class="fa-solid fa-book-open" aria-hidden="true"></i>

            <span class="navbar-wordmark">

                The Aulab
                <span>Post</span>

            </span>

        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Apri o chiudi il menu di navigazione">

            <span class="navbar-toggler-icon" aria-hidden="true"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="mainNavbar">


            <ul class="navbar-nav editorial-nav mx-xxl-auto gap-xxl-1">
                <li class="nav-item">
                    <a href="{{ route('homepage') }}" class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}" @if (request()->routeIs('homepage')) aria-current="page" @endif>Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" @if (request()->routeIs('articles.*')) aria-current="page" @endif>Articoli</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('homepage') }}#home-categories-title"
                        class="nav-link">
                        Categorie
                    </a>
                </li>

                @if (! auth()->user()?->hasRole('Writer', 'Admin'))
                <li class="nav-item">
                    <a href="{{ route('team.create') }}"
                        class="nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}"
                        @if (request()->routeIs('team.*')) aria-current="page" @endif>
                        Lavora con noi
                    </a>
                </li>
                @endif

                @if (! auth()->user()?->hasRole('Admin'))
                <li class="nav-item">
                    <a href="{{ route('feedback.create') }}"
                        class="nav-link {{ request()->routeIs('feedback.create') ? 'active' : '' }}"
                        @if (request()->routeIs('feedback.create')) aria-current="page" @endif>
                        Feedback
                    </a>
                </li>
                @endif

                @auth
                @php($navUser = auth()->user())
                @if ($navUser->hasRole('Writer'))
                <li class="nav-item"><a href="{{ route('writer.dashboard') }}" class="nav-link {{ request()->routeIs('writer.dashboard') ? 'active' : '' }}" @if (request()->routeIs('writer.dashboard')) aria-current="page" @endif>I miei articoli</a></li>
                @endif
                @if ($navUser->hasRole('Revisor', 'Admin'))
                <li class="nav-item"><a href="{{ route('review.index') }}" class="nav-link {{ request()->routeIs('review.index') ? 'active' : '' }}" @if (request()->routeIs('review.index')) aria-current="page" @endif>Revisione</a></li>
                @endif
                @if ($navUser->hasRole('Admin'))
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*', 'categories.*', 'tags.*') ? 'active' : '' }}" @if (request()->routeIs('admin.*', 'categories.*', 'tags.*')) aria-current="page" @endif>Amministrazione</a></li>
                <li class="nav-item">
                    <a href="{{ route('feedback.index') }}"
                        class="nav-link {{ request()->routeIs('feedback.index') ? 'active' : '' }}" @if (request()->routeIs('feedback.index')) aria-current="page" @endif>
                        Feedback ricevuti
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            <div class="navbar-tools ms-xxl-auto">

                @auth
                <div class="dropdown">
                    <button class="navbar-account dropdown-toggle" id="accountMenu"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false" aria-controls="accountMenuItems">

                        <span class="navbar-avatar">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </span>

                        <span class="navbar-username">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end navbar-account-menu" id="accountMenuItems" aria-labelledby="accountMenu">
                        <li>
                            <span class="dropdown-header">
                                {{ auth()->user()->role?->name ?? 'Utente' }}
                            </span>
                        </li>

                        @if (auth()->user()->hasRole('Writer'))
                        <li>
                            <a class="dropdown-item" href="{{ route('writer.dashboard') }}">
                                I miei articoli
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('articles.create') }}">
                                Inserisci articolo
                            </a>
                        </li>
                        @elseif (! auth()->user()->hasRole('Admin', 'Revisor'))
                        <li>
                            <a class="dropdown-item" href="{{ route('team.create') }}">
                                Lavora con noi
                            </a>
                        </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item navbar-logout" type="submit">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"
                                        aria-hidden="true"></i>
                                    Esci
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}"
                        class="btn btn-outline-light rounded-pill px-3">
                        Accedi
                    </a>
                    <a href="{{ route('register') }}"
                        class="btn btn-warning rounded-pill px-3 fw-semibold">
                        Registrati
                    </a>
                </div>
                @endauth
            </div>

        </div>

    </div>

</nav>