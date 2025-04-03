@extends('layouts.app')

@section('styles')
<!-- Styles spécifiques à l'interface pharmacie - optimisé pour mobile-first -->
<style>
    :root {
        --pharmacy-primary: #3c8168;
        --pharmacy-secondary: #2c6149;
        --pharmacy-light: #f8fafc;
        --white: #ffffff;
    }
    
    .pharmacy-header {
        background-color: var(--pharmacy-primary);
        color: white;
        padding: 1rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .pharmacy-header h1 {
        font-size: 1.5rem;
        margin: 0;
    }
    
    .pharmacy-section {
        background-color: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* Mobile-first sidebar */
    .pharmacy-sidebar {
        background-color: var(--pharmacy-light);
        margin-bottom: 1rem;
    }
    
    .pharmacy-sidebar h4 {
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
    
    /* Navigation mobile */
    .pharmacy-menu-toggle {
        display: block;
        width: 100%;
        background-color: var(--pharmacy-primary);
        color: white;
        border: none;
        padding: 0.75rem;
        font-size: 1rem;
        text-align: left;
        cursor: pointer;
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
    }
    
    .pharmacy-menu-toggle i {
        margin-right: 0.5rem;
    }
    
    .pharmacy-nav {
        display: none;
    }
    
    .pharmacy-nav.active {
        display: block;
    }
    
    .pharmacy-nav .nav-item {
        margin-bottom: 0;
    }
    
    .pharmacy-nav .nav-link {
        padding: 0.75rem;
        display: block;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }
    
    .pharmacy-nav .nav-link:hover,
    .pharmacy-nav .nav-link.active {
        background-color: rgba(60, 129, 104, 0.1);
        color: var(--pharmacy-primary);
    }
    
    /* Main content area */
    .pharmacy-content {
        padding: 0.5rem;
    }
    
    /* Media queries for larger screens */
    @media (min-width: 768px) {
        .pharmacy-header {
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .pharmacy-header h1 {
            font-size: 1.75rem;
            padding-left: 1rem;
        }
        
        .pharmacy-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .pharmacy-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .pharmacy-sidebar {
            flex: 0 0 250px;
            margin-bottom: 0;
        }
        
        .pharmacy-content {
            flex: 1;
            padding: 0;
        }
        
        .pharmacy-menu-toggle {
            display: none;
        }
        
        .pharmacy-nav {
            display: block;
        }
    }
</style>
@endsection

@section('content')
<div class="pharmacy-header">
    <h1>@yield('pharmacy-title', 'Espace Pharmacie')</h1>
</div>

<div class="container">
    <button class="pharmacy-menu-toggle" id="pharmacy-menu-toggle">
        <i class="fas fa-bars"></i> Menu Pharmacie
    </button>
    
    <div class="pharmacy-container">
        <div class="pharmacy-sidebar">
            <div class="pharmacy-section">
                <h4>Menu Pharmacie</h4>
                <ul class="nav flex-column pharmacy-nav" id="pharmacy-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.dashboard.*') ? 'active' : '' }}" href="{{ route('pharmacy.dashboard.index') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.inventory.*') ? 'active' : '' }}" href="{{ route('pharmacy.inventory.index') }}">
                            <i class="fas fa-pills mr-2"></i> Inventaire
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.reservations.*') ? 'active' : '' }}" href="{{ route('pharmacy.reservations.index') }}">
                            <i class="fas fa-calendar-check mr-2"></i> Réservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.profile.*') ? 'active' : '' }}" href="{{ route('pharmacy.profile.edit') }}">
                            <i class="fas fa-store mr-2"></i> Profil de la pharmacie
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="pharmacy-content">
            <div class="pharmacy-section">
                @yield('pharmacy-content')
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('pharmacy-menu-toggle');
        const nav = document.getElementById('pharmacy-nav');
        
        if (menuToggle && nav) {
            menuToggle.addEventListener('click', function() {
                nav.classList.toggle('active');
            });
            
            // Close menu on link click (mobile)
            const navLinks = nav.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        nav.classList.remove('active');
                    }
                });
            });
        }
    });
</script>
@endsection 