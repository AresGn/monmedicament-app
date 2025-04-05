<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="MonMédicament - Trouvez facilement vos médicaments dans les pharmacies proches de vous">
    <meta name="theme-color" content="#007BFF">
    
    <!-- PWA Capability -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    
    <title>{{ config('app.name') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #007BFF;
            --secondary: #28A745;
            --neutral: #F8F9FA;
            --white: #FFFFFF;
            --error: #DC3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        h1, h2, h3, .logo {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--neutral);
            font-size: 16px;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Mobile-first header */
        header {
            background: var(--white);
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 600;
            text-decoration: none;
            z-index: 2;
        }

        .logo:hover {
            color: var(--primary);
            text-decoration: none;
        }

        /* Mobile navigation */
        .mobile-menu-toggle {
            display: block;
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 2;
        }

        nav {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100vh;
            background: var(--white);
            z-index: 10;
            transition: left 0.3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            padding-top: 4rem;
        }

        nav.active {
            left: 0;
        }

        .nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9;
            display: none;
        }

        .nav-overlay.active {
            display: block;
        }

        nav ul {
            display: flex;
            flex-direction: column;
            gap: 0;
            list-style: none;
        }

        nav li {
            width: 100%;
            border-bottom: 1px solid #eee;
        }

        nav a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: block;
            padding: 1rem 1.5rem;
        }

        nav a:hover {
            color: var(--primary);
            background-color: #f5f5f5;
        }

        .header-buttons {
            display: flex;
            flex-direction: row;
            width: auto;
            padding: 0;
            gap: 0.75rem;
            margin-left: 1.5rem;
            display: flex;
            align-items: center;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            text-align: center;
            display: block;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-demo {
            background: var(--white);
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-demo:hover {
            background: rgba(0, 123, 255, 0.1);
            color: var(--primary);
            text-decoration: none;
        }

        .btn-login {
            background: var(--primary);
            color: var(--white);
        }

        .btn-login:hover {
            background: #0056b3;
            color: var(--white);
            text-decoration: none;
        }

        /* Style pour les boutons d'icônes */
        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            color: #444;
            transition: all 0.3s;
            padding: 0;
            margin: 0 0.25rem;
        }
        
        .btn-icon:hover {
            background-color: rgba(0, 123, 255, 0.15);
            color: var(--primary);
        }
        
        .btn-icon i {
            font-size: 1.2rem;
        }
        
        form .btn-icon:hover {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        /* Main content */
        main {
            padding: 1rem;
        }

        .section {
            margin-bottom: 2rem;
        }

        /* Mobile-first footer */
        footer {
            background: var(--primary);
            padding: 2rem 1rem;
            color: var(--white);
        }

        .footer-section {
            margin-bottom: 1.5rem;
        }

        footer h2, footer h3 {
            color: var(--white);
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 1.25rem;
        }

        footer p {
            color: var(--neutral);
            margin-bottom: 0.5rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        footer ul {
            list-style: none;
        }

        footer a {
            color: var(--neutral);
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            margin-bottom: 0.5rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        footer a:hover {
            color: var(--secondary);
            opacity: 1;
        }

        /* Media queries for larger screens */
        @media (min-width: 768px) {
            header {
                padding: 0.75rem 2rem;
            }
            
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 1200px;
                margin: 0 auto;
            }
            
            .mobile-menu-toggle {
                display: none;
            }
            
            nav {
                position: static;
                width: auto;
                height: auto;
                background: transparent;
                box-shadow: none;
                padding-top: 0;
                left: 0;
                display: flex;
                align-items: center;
            }
            
            nav ul {
                flex-direction: row;
                gap: 1.5rem;
                margin-bottom: 0;
                padding-left: 0;
            }
            
            nav li {
                width: auto;
                border-bottom: none;
            }
            
            nav a {
                padding: 0;
                color: #444;
            }
            
            nav a:hover {
                background-color: transparent;
                color: var(--primary);
            }
            
            .header-buttons {
                flex-direction: row;
                width: auto;
                padding: 0;
                gap: 0.75rem;
                margin-left: 1.5rem;
                display: flex;
                align-items: center;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            main {
                padding: 2rem;
            }
            
            footer {
                padding: 3rem 2rem;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
            }
            
            .footer-section {
                margin-bottom: 0;
            }
        }

        @media (min-width: 992px) {
            header {
                padding: 0.75rem 3rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            nav ul {
                gap: 2rem;
            }

            .btn {
                padding: 0.5rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
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

    <main class="py-3">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="py-4 mt-4">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <span class="footer-logo">MonMédicament</span>
                </div>
                <div class="col-auto">
                    <div class="footer-links">
                        <a href="{{ url('/about') }}">À propos</a>
                        <span class="separator">•</span>
                        <a href="{{ url('/privacy') }}">Confidentialité</a>
                        <span class="separator">•</span>
                        <a href="{{ url('/terms') }}">Conditions</a>
                        <span class="separator">•</span>
                        <a href="{{ url('/contact') }}">Contact</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <p class="copyright">© {{ date('Y') }} MonMédicament. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <style>
        /* Styles du footer minimaliste */
        footer {
            background-color: #f8f9fa;
            border-top: 1px solid rgba(0,0,0,0.05);
            font-family: 'Poppins', sans-serif;
        }

        .footer-logo {
            font-weight: 600;
            font-size: 1.2rem;
            color: #007BFF;
        }

        .footer-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .footer-links a {
            color: #555;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #007BFF;
        }

        .separator {
            color: #ccc;
            font-size: 0.8rem;
        }

        .copyright {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 0;
        }

        @media (max-width: 767.98px) {
            .row.align-items-center {
                flex-direction: column;
                text-align: center;
            }
            
            .col-auto {
                margin-bottom: 1rem;
            }
            
            .footer-links {
                justify-content: center;
            }
        }
    </style>

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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 