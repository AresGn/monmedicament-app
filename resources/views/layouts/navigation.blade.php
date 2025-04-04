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
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.home') }}#how-it-works">
                        Comment ça marche
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/patient/pharmacies') }}">
                        Pharmacies
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/contact') }}">
                        Contact
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" href="{{ route('patient.search.index') }}">
                            Voir une démo
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('patient.auth.login') }}">
                            Se connecter
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Auth::user()->user_type === 'PATIENT' ? route('patient.profile.edit') : route('pharmacy.profile.edit') }}" title="Mon compte">
                            <div class="auth-icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Déconnexion">
                            <div class="auth-icon logout-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                        </a>
                        
                        <form id="logout-form" action="{{ route('patient.auth.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Styles pour la navigation */
    .navbar {
        padding: 0.75rem 1rem;
    }
    
    .navbar-brand {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #007BFF;
        font-size: 1.4rem;
        margin-right: 2rem;
    }
    
    .navbar-nav .nav-link {
        color: #444;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
        font-size: 1rem;
    }
    
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #007BFF;
    }
    
    .btn-outline-primary {
        border-color: #007BFF;
        color: #007BFF;
        padding: 0.5rem 1.25rem;
        font-size: 0.95rem;
        border-radius: 4px;
    }
    
    .btn-primary {
        background-color: #007BFF;
        border-color: #007BFF;
        padding: 0.5rem 1.25rem;
        font-size: 0.95rem;
        border-radius: 4px;
    }
    
    .btn-outline-primary:hover {
        background-color: rgba(0, 123, 255, 0.1);
        color: #007BFF;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
    }
    
    .navbar-nav.mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
    
    .navbar-nav.mx-auto .nav-item {
        margin: 0 0.75rem;
    }
    
    /* Style pour les icônes de navigation */
    .navbar-nav .auth-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s;
        background-color: #f8f9fa;
    }
    
    .navbar-nav .auth-icon:hover {
        background-color: rgba(0, 123, 255, 0.15);
        color: #007BFF;
    }
    
    .navbar-nav .auth-icon i {
        font-size: 1.2rem;
        color: #444;
    }
    
    .navbar-nav .auth-icon:hover i {
        color: #007BFF;
    }
    
    /* Style spécifique pour l'icône de déconnexion */
    .navbar-nav .auth-icon.logout-icon:hover {
        background-color: rgba(220, 53, 69, 0.15);
    }
    
    .navbar-nav .auth-icon.logout-icon:hover i {
        color: #dc3545;
    }
    
    /* Styles responsive */
    @media (max-width: 767.98px) {
        .navbar-brand {
            font-size: 1.2rem;
        }
        
        .navbar-collapse {
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .navbar-nav .nav-item {
            padding: 0.25rem 0;
            text-align: center;
        }
        
        .navbar-nav .btn {
            display: block;
            width: 100%;
            margin-top: 0.5rem;
            text-align: center;
        }
        
        .navbar-nav .nav-item + .nav-item {
            margin-top: 0.5rem;
        }
        
        .navbar-nav .auth-icon {
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Style pour la barre d'authentification sur mobile */
        .navbar-nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .navbar-nav .nav-item {
            margin: 0.5rem;
            padding: 0;
            width: 100%;
        }
    }
    
    /* Styles pour grands écrans */
    @media (min-width: 768px) {
        .navbar {
            padding: 0.75rem 2rem;
        }
        
        .navbar-nav .nav-item {
            margin: 0 0.75rem;
        }
        
        .btn {
            padding: 0.5rem 1.25rem;
        }
    }
    
    @media (min-width: 992px) {
        .navbar {
            padding: 0.75rem 3rem;
        }
        
        .container {
            max-width: 1200px;
        }
        
        .navbar-nav .nav-item {
            margin: 0 1rem;
        }
    }
</style> 