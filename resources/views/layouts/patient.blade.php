<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    @include('components.navigation')
    
    <main>
            @yield('content')
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html> 