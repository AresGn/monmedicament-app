<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <a href="{{ url('/') }}">{{ config('app.name', 'MonMédicament') }}</a>
            </div>
            <div class="footer-links">
                <a href="{{ url('/about') }}">À propos</a>
                <a href="{{ url('/privacy') }}">Confidentialité</a>
                <a href="{{ url('/terms') }}">Conditions</a>
                <a href="{{ url('/contact') }}">Contact</a>
            </div>
        </div>
        <div class="copyright">
            © {{ date('Y') }} {{ config('app.name', 'MonMédicament') }}. Tous droits réservés.
        </div>
    </div>
</footer> 