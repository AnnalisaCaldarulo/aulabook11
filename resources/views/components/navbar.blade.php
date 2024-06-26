<nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('book.index') }}">index</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Categorie
                    </a>
                    <ul class="dropdown-menu">
                        {{-- @foreach ($categories as $category)
                            <li class="nav-item">
                            <li class="nav-item">
                                <form action="{{ route('book.category', $category) }}" method="GET">
                                    <button type="submit" class="nav-link">{{ $category->name }}</button>
                                </form>
                            </li>
                        @endforeach --}}

                        @foreach ($categories as $category)
                            <li class="nav-item">
                            <li class="nav-item">
                                <form action="{{ route('book.indexFilters') }}" method="GET">
                                    <input type="hidden" name="categoryChecked[0]" value="{{ $category->id }}">
                                    <button type="submit" class="nav-link">{{ $category->name }}</button>
                                </form>
                            </li>
                        @endforeach
                </li>
            </ul>

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            @endguest

            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Benventuto {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <li><a class="dropdown-item" href="{{ route('book.create') }}">Crea</a></li>

                        @if (Auth::user()->isRevisor() || Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('revisor.index') }}">Zona Revisore</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.profile') }}">Profilo</a>
                        </li>
                    </ul>
                </li>
            @endauth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Dropdown
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-globe-americas"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end lang-menu m-0 p-0">
                        <li class="nav-item ms-0 dropdown-item px-0">
                            <x-locale lang='it' nation='it' />
                        </li>
                        <li class="nav-item ms-0 dropdown-item px-0">
                            <x-locale lang='en' nation='en' />
                        </li>
                    </ul>
                </li>
            </ul>

            <form class="d-flex" method="GET" action="{{ route('book.indexFilters') }}">
                <input name="searched" class="form-control me-2" type="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
