<nav class="navbar navbar-expand-xl navbar-dark border-bottom border-secondary-subtle bg-black sticky-top">

    <div class="container-fluid px-4 px-xl-5">

        <a href="{{ route('homepage') }}"
            class="navbar-brand d-flex align-items-center gap-2">

            {{ $slot }}

            <i class="fa-solid fa-book-open text-warning fs-2"></i>

            <span class="font-serif fs-3 fw-bold">

                The Aulab
                <span class="text-warning">Post</span>

            </span>

        </a>


        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="mainNavbar">


            <ul class="navbar-nav mx-xl-5 gap-xl-3">
                <li class="nav-item">
                    <a href="{{ route('homepage') }}" class="nav-link {{ request()->routeIs('homepage') ? 'active text-warning' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active text-warning' : '' }}">Articoli</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('homepage') }}#home-categories-title"
                        class="nav-link">
                        Categorie
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('team.create') }}"
                        class="nav-link {{ request()->routeIs('team.*') ? 'active text-warning' : '' }}">
                        Lavora con noi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('feedback.create') }}"
                        class="nav-link {{ request()->routeIs('feedback.*') ? 'active text-warning' : '' }}">
                        Feedback
                    </a>
                </li>
                @auth
                @php($navUser = auth()->user())
                @if ($navUser->hasRole('Writer'))
                <li class="nav-item"><a href="{{ route('writer.dashboard') }}" class="nav-link">I miei articoli</a></li>
                @endif
                @if ($navUser->hasRole('Revisor', 'Admin'))
                <li class="nav-item"><a href="{{ route('review.index') }}" class="nav-link">Revisione</a></li>
                @endif
                @if ($navUser->hasRole('Admin'))
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Amministrazione</a></li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('feedback.index') }}"
                        class="nav-link {{ request()->routeIs('feedback.index') ? 'active text-warning' : '' }}">
                        Feedback ricevuti
                    </a>
                </li>
                @endauth
            </ul>

            <div class="navbar-tools ms-auto">

                @auth
                <div class="dropdown">
                    <button class="navbar-account dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <span class="navbar-avatar">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                        </span>

                        <span class="navbar-username">
                            {{ auth()->user()->name }}
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end navbar-account-menu">
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