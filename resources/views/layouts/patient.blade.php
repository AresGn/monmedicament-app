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
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
            padding: 1rem 1.5rem;
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
    <header>
        <div class="header-container">
            <a href="{{ route('patient.home') }}" class="logo">MonMedicament</a>
            <button class="mobile-menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="nav-overlay" id="nav-overlay"></div>
            <nav id="mobile-nav">
                <ul>
                    <li><a href="#how-it-works">Comment ça marche</a></li>
                    <li><a href="{{ route('patient.search.pharmacy.list') }}">Pharmacies</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="header-buttons">
                    <a href="#demo" class="btn btn-demo">Voir une démo</a>
                    @auth
                        @if(Auth::user()->user_type === 'PATIENT')
                            <a href="{{ route('patient.dashboard') }}" class="btn btn-login">Mon compte</a>
                            <form action="{{ route('patient.auth.logout') }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="btn btn-demo" style="width: 100%;">Déconnexion</button>
                            </form>
                        @else
                            <a href="{{ route('patient.auth.login') }}" class="btn btn-login">Se connecter</a>
                        @endif
                    @else
                        <a href="{{ route('patient.auth.login') }}" class="btn btn-login">Se connecter</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-section">
            <h2>MonMedicament</h2>
            <p>Votre solution pour trouver vos médicaments rapidement et efficacement.</p>
        </div>
        <div class="quick-links">
            <h3>Liens Rapides</h3>
            <ul>
                <li><a href="{{ route('patient.home') }}">Accueil</a></li>
                <li><a href="{{ route('patient.search.index') }}">Recherche</a></li>
                <li><a href="{{ route('patient.search.pharmacy.list') }}">Pharmacies</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </div>
        <div class="legal">
            <h3>Légal</h3>
            <ul>
                <li><a href="#terms">Conditions d'utilisation</a></li>
                <li><a href="#privacy">Politique de confidentialité</a></li>
                <li><a href="#legal">Mentions légales</a></li>
            </ul>
        </div>
        <div class="contact-info">
            <h3>Contact</h3>
            <p>Email: support@monmedicament.com</p>
            <p>Téléphone: +229 01 23 45 67 89</p>
            <p>Réseaux sociaux: MonMedicament</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileNav = document.getElementById('mobile-nav');
            const navOverlay = document.getElementById('nav-overlay');
            
            menuToggle.addEventListener('click', function() {
                mobileNav.classList.toggle('active');
                navOverlay.classList.toggle('active');
                document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
            });
            
            navOverlay.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                navOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Close menu when clicking on a link
            const navLinks = mobileNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileNav.classList.remove('active');
                    navOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html> 