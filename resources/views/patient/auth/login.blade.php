@extends('layouts.patient')

@section('title', 'Connexion')

@push('styles')
<style>
    .auth-container {
        max-width: 500px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .auth-header p {
        color: #666;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        width: 100%;
    }

    .btn:hover {
        background-color: #0062cc;
        transform: translateY(-2px);
    }

    .forgot-password {
        text-align: right;
        margin-bottom: 1.5rem;
    }

    .forgot-password a {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        color: #666;
    }

    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .social-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 2rem 0;
    }

    .social-divider::before,
    .social-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #ddd;
    }

    .social-divider span {
        padding: 0 1rem;
        color: #666;
    }

    .social-login {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border-radius: 0.5rem;
        color: var(--white);
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-btn:hover {
        transform: translateY(-2px);
    }

    .google-btn {
        background-color: #db4437;
    }

    .facebook-btn {
        background-color: #4267B2;
    }

    .validation-error {
        color: var(--error);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.5rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Connexion</h1>
        <p>Connectez-vous pour accéder à votre compte</p>
    </div>

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info" role="alert">
        {{ session('info') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('patient.auth.login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Temporairement désactivé en attendant la migration
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Se souvenir de moi</label>
            </div>
        </div>
        -->
        
        <div class="forgot-password">
            <a href="{{ route('patient.auth.password.request') }}">Mot de passe oublié?</a>
        </div>
        
        <button type="submit" class="btn">Se connecter</button>
    </form>
    
    <div class="social-divider">
        <span>OU</span>
    </div>
    
    <div class="social-login">
        <a href="{{ route('patient.auth.redirect', ['provider' => 'google']) }}" class="social-btn google-btn">
            <i class="fab fa-google"></i> Google
        </a>
        <a href="{{ route('patient.auth.redirect', ['provider' => 'facebook']) }}" class="social-btn facebook-btn">
            <i class="fab fa-facebook-f"></i> Facebook
        </a>
    </div>
    
    <div class="auth-footer">
        Vous n'avez pas de compte? <a href="{{ route('patient.auth.register') }}">S'inscrire</a>
    </div>
</div>
@endsection 