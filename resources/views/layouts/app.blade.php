<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MonMédicament - Trouvez facilement vos médicaments dans les pharmacies proches de vous">
    <meta name="theme-color" content="#007BFF">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PWA Capability -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <title>{{ config('app.name', 'MonMédicament') }} - @yield('title', 'Accueil')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
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
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            background-color: var(--neutral);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        /* Mobile-first footer */
        footer {
            background-color: var(--primary);
            color: var(--white);
            padding: 2rem 0;
        }

        footer h5 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        footer .list-unstyled {
            padding-left: 0;
        }

        footer a {
            color: var(--white);
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        footer a:hover {
            opacity: 1;
            color: var(--white);
        }

        /* Mobile optimization */
        @media (max-width: 576px) {
            body {
                font-size: 14px;
            }
            
            .container {
                padding-right: 10px;
                padding-left: 10px;
            }
            
            footer .col-md-6, 
            footer .col-md-12, 
            footer .col-lg-6, 
            footer .col-lg-3 {
                margin-bottom: 1.5rem;
            }
        }
    </style>
    
    @yield('styles')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="app">
        @include('layouts.navigation')

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

        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-logo">
                        <a href="{{ url('/') }}">MonMédicament</a>
                    </div>
                    <div class="footer-links">
                        <a href="{{ url('/about') }}">À propos</a>
                        <a href="{{ url('/privacy') }}">Confidentialité</a>
                        <a href="{{ url('/terms') }}">Conditions</a>
                        <a href="{{ url('/contact') }}">Contact</a>
                    </div>
                </div>
                <div class="copyright">
                    © {{ date('Y') }} MonMédicament. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>

    <style>
        /* Minimalist Footer Styles */
        .footer {
            background-color: #f8f8f8;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid #eaeaea;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo a {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--primary);
            text-decoration: none;
        }
        
        .footer-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .copyright {
            text-align: center;
            color: #888;
            font-size: 0.85rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
        }
    </style>

    @yield('scripts')
</body>
</html> 