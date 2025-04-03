<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }

        header {
            background: var(--white);
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
        }

        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        nav a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--primary);
        }

        .header-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-demo {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-demo:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-login {
            background: var(--primary);
            color: var(--white);
        }

        .btn-login:hover {
            background: #0056b3;
        }

        footer {
            background: var(--primary);
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            color: var(--white);
        }

        footer h2, footer h3 {
            color: var(--white);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        footer p {
            color: var(--neutral);
            margin-bottom: 0.5rem;
            opacity: 0.9;
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
        }

        footer a:hover {
            color: var(--secondary);
            opacity: 1;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }

            .header-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <header>
        <a href="{{ route('patient.home') }}" class="logo">MonMedicament</a>
        <nav>
            <ul>
                <li><a href="#how-it-works">Comment ça marche</a></li>
                <li><a href="{{ route('patient.search.pharmacy.list') }}">Pharmacies</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <div class="header-buttons">
            <a href="#demo" class="btn btn-demo">Voir une démo</a>
            @auth
                @if(Auth::user()->user_type === 'PATIENT')
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-login">Mon compte</a>
                    <form action="{{ route('patient.auth.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-demo">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('patient.auth.login') }}" class="btn btn-login">Se connecter</a>
                @endif
            @else
                <a href="{{ route('patient.auth.login') }}" class="btn btn-login">Se connecter</a>
            @endauth
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

    @stack('scripts')
</body>
</html> 