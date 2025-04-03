@extends('layouts.app')

@section('styles')
<!-- Styles spécifiques à l'interface pharmacie -->
<style>
    .pharmacy-header {
        background-color: #3c8168;
        color: white;
        padding: 1rem 0;
        margin-bottom: 2rem;
    }
    
    .pharmacy-section {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .pharmacy-sidebar {
        background-color: #f8fafc;
        border-right: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')
<div class="pharmacy-header">
    <div class="container">
        <h1>@yield('pharmacy-title', 'Espace Pharmacie')</h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="pharmacy-section pharmacy-sidebar">
                <h4>Menu Pharmacie</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.dashboard.*') ? 'active' : '' }}" href="{{ route('pharmacy.dashboard.index') }}">
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.inventory.*') ? 'active' : '' }}" href="{{ route('pharmacy.inventory.index') }}">
                            Inventaire
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.reservations.*') ? 'active' : '' }}" href="{{ route('pharmacy.reservations.index') }}">
                            Réservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pharmacy.profile.*') ? 'active' : '' }}" href="{{ route('pharmacy.profile.edit') }}">
                            Profil de la pharmacie
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="pharmacy-section">
                @yield('pharmacy-content')
            </div>
        </div>
    </div>
</div>
@endsection 