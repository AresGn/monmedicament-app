<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MonMédicament') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->user_type === 'PATIENT')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patient.search.*') ? 'active' : '' }}" href="{{ route('patient.search.index') }}">Rechercher un médicament</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patient.reservations.*') ? 'active' : '' }}" href="{{ route('patient.reservations.index') }}">Mes réservations</a>
                        </li>
                    @elseif(Auth::user()->user_type === 'PHARMACY')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.dashboard.*') ? 'active' : '' }}" href="{{ route('pharmacy.dashboard.index') }}">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.inventory.*') ? 'active' : '' }}" href="{{ route('pharmacy.inventory.index') }}">Inventaire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.reservations.*') ? 'active' : '' }}" href="{{ route('pharmacy.reservations.index') }}">Réservations</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patient.search.*') ? 'active' : '' }}" href="{{ route('patient.search.index') }}">Rechercher un médicament</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('patient.auth.login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.auth.login') }}">{{ __('Connexion') }}</a>
                        </li>
                    @endif

                    @if (Route::has('patient.auth.register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.auth.register') }}">{{ __('Inscription') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->full_name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->user_type === 'PATIENT')
                                <a class="dropdown-item" href="{{ route('patient.profile.edit') }}">
                                    Mon profil
                                </a>
                            @elseif(Auth::user()->user_type === 'PHARMACY')
                                <a class="dropdown-item" href="{{ route('pharmacy.profile.edit') }}">
                                    Profil de la pharmacie
                                </a>
                            @endif
                            
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form" action="{{ route('patient.auth.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> 