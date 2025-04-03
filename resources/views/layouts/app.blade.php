<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MonMédicament') }} - @yield('title', 'Accueil')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="app">
        @include('layouts.navigation')

        <main class="py-4">
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

        <footer class="bg-light text-center text-lg-start mt-5">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">MonMédicament</h5>
                        <p>
                            Trouvez facilement vos médicaments dans les pharmacies proches de chez vous.
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Liens utiles</h5>
                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-dark">À propos</a></li>
                            <li><a href="#!" class="text-dark">Confidentialité</a></li>
                            <li><a href="#!" class="text-dark">Conditions d'utilisation</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Contact</h5>
                        <ul class="list-unstyled mb-0">
                            <li><a href="#!" class="text-dark">Support</a></li>
                            <li><a href="#!" class="text-dark">Nous contacter</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © {{ date('Y') }} Droits réservés:
                <a class="text-dark" href="#">MonMédicament</a>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>
</html> 