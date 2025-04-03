@extends('layouts.patient')

@section('title', 'Détails de la pharmacie')

@push('styles')
<style>
    /* Mobile-first styles */
    .pharmacy-details {
        padding: 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        margin-bottom: 1rem;
        font-weight: 500;
        text-decoration: none;
    }

    .pharmacy-header {
        margin-bottom: 2rem;
    }

    .pharmacy-name {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .pharmacy-info {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-icon {
        color: var(--primary);
        font-size: 1.2rem;
        flex-shrink: 0;
        margin-top: 0.2rem;
    }

    .info-content {
        flex-grow: 1;
    }

    .info-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .info-value {
        color: #333;
        font-weight: 500;
    }

    .section-title {
        font-size: 1.2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .inventory-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .medicine-card {
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1rem;
        border-left: 4px solid var(--primary);
    }

    .medicine-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .medicine-details {
        font-size: 0.9rem;
        color: #666;
    }

    .medicine-details p {
        margin: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .medicine-details i {
        color: var(--primary);
        font-size: 0.9rem;
    }

    .stock-available {
        color: var(--secondary);
    }

    .stock-low {
        color: #f59f00;
    }

    .stock-none {
        color: var(--error);
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-pharmacy-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        text-align: center;
    }

    .btn-reserve {
        background: var(--primary);
        color: var(--white);
    }

    .btn-direction {
        background: var(--secondary);
        color: var(--white);
    }

    .btn-call {
        background: #0D9488;
        color: var(--white);
    }

    .btn-pharmacy-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Map container */
    .map-container {
        height: 250px;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* Tablet and larger */
    @media (min-width: 768px) {
        .pharmacy-details {
            padding: 2rem;
        }

        .pharmacy-name {
            font-size: 2rem;
        }

        .pharmacy-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .inventory-list {
            grid-template-columns: repeat(2, 1fr);
        }

        .action-buttons {
            flex-direction: row;
        }

        .map-container {
            height: 350px;
        }
    }

    /* Desktop */
    @media (min-width: 1024px) {
        .inventory-list {
            grid-template-columns: repeat(3, 1fr);
        }

        .map-container {
            height: 400px;
        }
    }
</style>
@endpush

@section('content')
<div class="pharmacy-details">
    <a href="{{ url()->previous() }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour
    </a>

    <div class="pharmacy-header">
        <h1 class="pharmacy-name">{{ $pharmacy->name }}</h1>
    </div>

    <div class="pharmacy-info">
        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="info-content">
                <div class="info-label">Adresse</div>
                <div class="info-value">{{ $pharmacy->address }}</div>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-phone"></i>
            </div>
            <div class="info-content">
                <div class="info-label">Téléphone</div>
                <div class="info-value">{{ $pharmacy->phone_number }}</div>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="info-content">
                <div class="info-label">Horaires d'ouverture</div>
                <div class="info-value">
                    @if($pharmacy->opening_hours)
                        {{ $pharmacy->opening_hours }}
                    @else
                        Lun-Ven: 8h-20h, Sam: 9h-18h, Dim: Fermé
                    @endif
                </div>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-pills"></i>
            </div>
            <div class="info-content">
                <div class="info-label">Médicaments disponibles</div>
                <div class="info-value">{{ $pharmacy->inventory->count() }} médicaments</div>
            </div>
        </div>
    </div>

    @if($pharmacy->latitude && $pharmacy->longitude)
    <div class="map-container" id="map"></div>
    @endif

    <div class="action-buttons">
        <a href="tel:{{ preg_replace('/\s+/', '', $pharmacy->phone_number) }}" class="btn-pharmacy-action btn-call">
            <i class="fas fa-phone"></i> Appeler
        </a>
        @if($pharmacy->latitude && $pharmacy->longitude)
        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" target="_blank" class="btn-pharmacy-action btn-direction">
            <i class="fas fa-directions"></i> Itinéraire
        </a>
        @endif
        @auth
        <a href="{{ route('patient.reservations.create', ['pharmacy_id' => $pharmacy->id]) }}" class="btn-pharmacy-action btn-reserve">
            <i class="fas fa-calendar-plus"></i> Réserver
        </a>
        @else
        <a href="{{ route('patient.auth.login') }}?redirect={{ route('patient.reservations.create', ['pharmacy_id' => $pharmacy->id]) }}" class="btn-pharmacy-action btn-reserve">
            <i class="fas fa-calendar-plus"></i> Se connecter pour réserver
        </a>
        @endauth
    </div>

    <h2 class="section-title">Médicaments disponibles</h2>

    <div class="inventory-list">
        @forelse($pharmacy->inventory as $item)
        <div class="medicine-card">
            <h3 class="medicine-name">{{ $item->medicine->name }}</h3>
            <div class="medicine-details">
                @if($item->medicine->generic_name)
                <p><i class="fas fa-prescription-bottle-alt"></i> {{ $item->medicine->generic_name }}</p>
                @endif
                <p>
                    <i class="fas fa-cubes"></i> 
                    @if($item->quantity_available > 10)
                    <span class="stock-available">En stock ({{ $item->quantity_available }})</span>
                    @elseif($item->quantity_available > 0)
                    <span class="stock-low">Stock limité ({{ $item->quantity_available }})</span>
                    @else
                    <span class="stock-none">Rupture de stock</span>
                    @endif
                </p>
                @if($item->price)
                <p><i class="fas fa-tag"></i> {{ number_format($item->price, 0, ',', ' ') }} FCFA</p>
                @endif
            </div>
        </div>
        @empty
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Aucun médicament listé pour cette pharmacie.
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
@if($pharmacy->latitude && $pharmacy->longitude)
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key', '') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const pharmacyLocation = {
            lat: {{ $pharmacy->latitude }},
            lng: {{ $pharmacy->longitude }}
        };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: pharmacyLocation,
        });
        
        const marker = new google.maps.Marker({
            position: pharmacyLocation,
            map: map,
            title: "{{ $pharmacy->name }}"
        });
    }
</script>
@endif
@endpush 