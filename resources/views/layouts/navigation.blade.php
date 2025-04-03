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
                            <a class="nav-link {{ request()->routeIs('patient.search.*') ? 'active' : '' }}" href="#">
                                <i class="fas fa-search d-inline d-md-none me-2"></i>Rechercher
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('patient.reservations.*') ? 'active' : '' }}" href="{{ route('patient.reservations.index') }}">
                                <i class="fas fa-calendar-check d-inline d-md-none me-2"></i>Réservations
                            </a>
                        </li>
                    @elseif(Auth::user()->user_type === 'PHARMACY')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.dashboard.*') ? 'active' : '' }}" href="{{ route('pharmacy.dashboard.index') }}">
                                <i class="fas fa-tachometer-alt d-inline d-md-none me-2"></i>Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.inventory.*') ? 'active' : '' }}" href="{{ route('pharmacy.inventory.index') }}">
                                <i class="fas fa-pills d-inline d-md-none me-2"></i>Inventaire
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pharmacy.reservations.*') ? 'active' : '' }}" href="{{ route('pharmacy.reservations.index') }}">
                                <i class="fas fa-calendar-check d-inline d-md-none me-2"></i>Réservations
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('patient.search.*') ? 'active' : '' }}" href="#">
                            <i class="fas fa-search d-inline d-md-none me-2"></i>Rechercher
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('patient.auth.login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.auth.login') }}">
                                <i class="fas fa-sign-in-alt d-inline d-md-none me-2"></i>{{ __('Connexion') }}
                            </a>
                        </li>
                    @endif

                    @if (Route::has('patient.auth.register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.auth.register') }}">
                                <i class="fas fa-user-plus d-inline d-md-none me-2"></i>{{ __('Inscription') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-user-circle d-inline d-md-none me-2"></i>{{ Auth::user()->full_name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->user_type === 'PATIENT')
                                <a class="dropdown-item" href="{{ route('patient.profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Mon profil
                                </a>
                            @elseif(Auth::user()->user_type === 'PHARMACY')
                                <a class="dropdown-item" href="{{ route('pharmacy.profile.edit') }}">
                                    <i class="fas fa-store me-2"></i>Profil de la pharmacie
                                </a>
                            @endif
                            
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('Déconnexion') }}
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

<style>
    /* Styles pour la navigation */
    .navbar {
        padding: 0.5rem 1rem;
    }
    
    .navbar-brand {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--primary);
    }
    
    .navbar-nav .nav-link {
        color: #444;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s;
    }
    
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: var(--primary);
    }
    
    .dropdown-menu {
        border-radius: 0.25rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
        padding: 0.5rem 0;
    }
    
    .dropdown-item {
        padding: 0.5rem 1.5rem;
        color: #444;
    }
    
    .dropdown-item:hover {
        background-color: rgba(0, 123, 255, 0.1);
        color: var(--primary);
    }
    
    /* Styles mobile-first pour la navigation */
    @media (max-width: 767.98px) {
        .navbar-brand {
            font-size: 1.1rem;
        }
        
        .navbar-collapse {
            margin-top: 1rem;
        }
        
        .navbar-nav .nav-item {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .navbar-nav .nav-link {
            padding: 0.75rem 0.5rem;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: none;
            padding-left: 1rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 0;
        }
    }
    
    /* Styles pour grands écrans */
    @media (min-width: 768px) {
        .navbar {
            padding: 0.5rem 2rem;
        }
        
        .container {
            max-width: 1200px;
        }
        
        .navbar-nav {
            align-items: center;
        }
        
        .navbar-nav .nav-item {
            margin: 0 0.25rem;
        }
    }
    
    @media (min-width: 992px) {
        .navbar {
            padding: 0.5rem 3rem;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-item {
            margin: 0 0.5rem;
        }
    }
</style> 