@extends('layouts.patient')

@section('title', $pharmacy->name . ' - MonMédicament')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Palette de couleurs */
    :root {
        --primary: #007BFF;
        --secondary: #28A745;
        --light-gray: #F8F9FA;
        --white: #FFFFFF;
        --danger: #DC3545;
        --warning: #FFC107;
        --text-dark: #333333;
        --text-gray: #666666;
    }

    /* Mobile-first styles */
    .page-header {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        font-weight: 500;
        text-decoration: none;
    }

    .pharmacy-details {
        padding: 0;
        max-width: 1200px;
        margin: 0 auto;
    }

    .pharmacy-hero {
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
        background-color: var(--white);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .pharmacy-main-info {
        flex: 1;
    }

    .pharmacy-image {
        width: 100%;
        height: 200px;
        margin-top: 1.5rem;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .pharmacy-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pharmacy-name {
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .rating {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .stars {
        color: var(--warning);
        font-size: 1rem;
    }

    .reviews {
        color: var(--text-gray);
        font-size: 0.9rem;
    }

    .status-info {
        margin-bottom: 1rem;
    }

    .status-info p {
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-gray);
    }

    .status-open {
        color: var(--secondary) !important;
    }

    .contact-info {
        margin-bottom: 1.5rem;
    }

    .contact-info p {
        margin: 0.5rem 0;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        color: var(--text-gray);
    }

    .contact-info i {
        margin-top: 0.2rem;
        color: var(--primary);
    }

    .btn-reserve {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        width: 100%;
    }

    .btn-reserve:hover {
        background-color: #0069d9;
        transform: translateY(-2px);
    }
    
    .content-wrapper {
        display: flex;
        flex-direction: column;
        padding: 0 1.5rem 2rem;
        gap: 1.5rem;
    }

    .left-column, .right-column {
        width: 100%;
    }

    .services-section, .hours-section, .reviews-section, .map-section, .photos-section {
        background-color: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .services-section h2, .hours-section h2, .reviews-section h2, .map-section h2, .photos-section h2 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.2rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .services-section h2 i, .hours-section h2 i, .reviews-section h2 i, .map-section h2 i, .photos-section h2 i {
        color: var(--primary);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .service-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: #f8f9fa;
    }

    .service-item i {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .service-item span {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .service-item small {
        color: var(--text-gray);
        font-size: 0.8rem;
    }

    .hours-table {
        width: 100%;
    }

    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
    }

    .hours-row:last-child {
        border-bottom: none;
    }

    .day {
        font-weight: 600;
        color: var(--text-dark);
    }

    .hours {
        color: var(--text-gray);
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .btn-add-review {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add-review:hover {
        background-color: var(--primary);
        color: var(--white);
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .review-card {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.25rem;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .reviewer-info h3 {
        font-size: 1rem;
        margin: 0 0 0.25rem;
        color: var(--text-dark);
    }

    .review-date {
        font-size: 0.8rem;
        color: var(--text-gray);
    }

    .review-text {
        color: var(--text-gray);
        line-height: 1.5;
        margin: 0;
    }

    #map {
        width: 100%;
        height: 250px;
        border-radius: 0.5rem;
    }

    .link-google-maps {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        margin-top: 1rem;
        font-size: 0.9rem;
    }

    .photos-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .photos-count {
        font-size: 0.9rem;
        color: var(--text-gray);
    }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .photo-thumbnail {
        aspect-ratio: 1/1;
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .photo-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .photo-thumbnail img:hover {
        transform: scale(1.05);
    }

    .link-all-photos {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
    }

    /* Inventory section */
    .inventory-section {
        background-color: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .inventory-section h2 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.2rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .inventory-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .medicine-card {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.25rem;
        border-left: 4px solid var(--primary);
    }

    .medicine-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.75rem;
    }

    .medicine-details {
        color: var(--text-gray);
    }

    .medicine-details p {
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .medicine-details i {
        color: var(--primary);
    }

    .stock-available {
        color: var(--secondary);
    }

    .stock-low {
        color: var(--warning);
    }

    .stock-none {
        color: var(--danger);
    }

    /* Tablet and larger screens */
    @media (min-width: 768px) {
        .pharmacy-hero {
            flex-direction: row;
            gap: 2rem;
        }

        .pharmacy-image {
            width: 40%;
            height: auto;
            margin-top: 0;
        }

        .btn-reserve {
            width: auto;
        }

        .content-wrapper {
            flex-direction: row;
        }

        .left-column {
            width: 60%;
        }

        .right-column {
            width: 40%;
        }

        .services-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .inventory-list {
            grid-template-columns: repeat(2, 1fr);
        }

        #map {
            height: 350px;
        }
    }

    /* Desktop */
    @media (min-width: 1024px) {
        .pharmacy-name {
            font-size: 2.2rem;
        }

        .inventory-list {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endpush

@section('content')
<header class="page-header">
    <a href="{{ url()->previous() }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour aux résultats
    </a>
</header>

<main class="pharmacy-details">
    <div class="pharmacy-hero">
        <div class="pharmacy-main-info">
            <h1 class="pharmacy-name">{{ $pharmacy->name }}</h1>
            <div class="rating">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="reviews">4.5/5 ({{ random_int(15, 150) }} avis)</span>
            </div>
            <div class="status-info">
                <p class="status-open"><i class="far fa-clock"></i> Ouvert aujourd'hui jusqu'à 20h</p>
                <p class="status-distance"><i class="fas fa-car"></i> Distance estimée: {{ random_int(500, 3000) }}m</p>
            </div>
            <div class="contact-info">
                <p><i class="fas fa-map-marker-alt"></i> {{ $pharmacy->address }}</p>
                <p><i class="fas fa-phone"></i> {{ $pharmacy->phone_number }}</p>
                @if($pharmacy->email)
                <p><i class="fas fa-envelope"></i> {{ $pharmacy->email }}</p>
                @endif
            </div>
            @if(Auth::check() && Auth::user()->user_type === 'PATIENT')
            <a href="{{ route('patient.reservations.create', ['pharmacy_id' => $pharmacy->id]) }}" class="btn-reserve">
                <i class="fas fa-calendar-check"></i>
                <span>Réserver</span>
            </a>
            @else
            <a href="{{ route('patient.auth.login') }}?redirect={{ route('patient.reservations.create', ['pharmacy_id' => $pharmacy->id]) }}" class="btn-reserve">
                <i class="fas fa-calendar-check"></i>
                <span>Réserver</span>
            </a>
            @endif
        </div>
        <div class="pharmacy-image">
            <img src="{{ asset('img/pharmacy-placeholder.jpg') }}" alt="{{ $pharmacy->name }}" loading="lazy" onerror="this.src='https://via.placeholder.com/800x500.jpg?text=Pharmacie'; this.onerror=null;">
        </div>
    </div>

    <div class="content-wrapper">
        <div class="left-column">
            <section class="services-section">
                <h2><i class="fas fa-concierge-bell"></i> Services</h2>
                <div class="services-grid">
                    <div class="service-item">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Click & Collect</span>
                        <small>Retrait en 1h</small>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-truck"></i>
                        <span>Livraison</span>
                        <small>En 30min - 1h</small>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-credit-card"></i>
                        <span>Paiement CB</span>
                        <small>Sans minimum</small>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-comments"></i>
                        <span>Conseil en ligne</span>
                        <small>Chat disponible</small>
                    </div>
                </div>
            </section>

            <section class="hours-section">
                <h2><i class="far fa-clock"></i> Horaires d'ouverture</h2>
                <div class="hours-table">
                    <div class="hours-row">
                        <span class="day">Lundi</span>
                        <span class="hours">9h00 - 20h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Mardi</span>
                        <span class="hours">9h00 - 20h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Mercredi</span>
                        <span class="hours">9h00 - 20h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Jeudi</span>
                        <span class="hours">9h00 - 20h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Vendredi</span>
                        <span class="hours">9h00 - 20h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Samedi</span>
                        <span class="hours">10h00 - 19h00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Dimanche</span>
                        <span class="hours">Fermé</span>
                    </div>
                </div>
            </section>

            <section class="reviews-section">
                <div class="reviews-header">
                    <h2><i class="fas fa-star"></i> Avis clients</h2>
                    <button class="btn-add-review">
                        <i class="fas fa-pen"></i> Laisser un avis
                    </button>
                </div>
                <div class="reviews-list">
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Marie D." class="reviewer-avatar">
                            <div class="reviewer-info">
                                <h3>Marie D.</h3>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="review-date">Il y a 2 jours</span>
                            </div>
                        </div>
                        <p class="review-text">Personnel très accueillant et professionnel. Service rapide et efficace. Je recommande vivement cette pharmacie !</p>
                    </div>
                    <div class="review-card">
                        <div class="review-header">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Pierre L." class="reviewer-avatar">
                            <div class="reviewer-info">
                                <h3>Pierre L.</h3>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="review-date">Il y a 1 semaine</span>
                            </div>
                        </div>
                        <p class="review-text">Très bonne pharmacie, équipe compétente et à l'écoute. Seul bémol : l'attente peut être un peu longue aux heures de pointe.</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="right-column">
            <section class="map-section">
                <h2><i class="fas fa-map-marked-alt"></i> Localisation</h2>
                <div id="map"></div>
                @if($pharmacy->latitude && $pharmacy->longitude)
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" target="_blank" class="link-google-maps">
                    <i class="fab fa-google"></i> Voir sur Google Maps
                </a>
                @endif
            </section>

            <section class="photos-section">
                <div class="photos-header">
                    <h2><i class="fas fa-images"></i> Photos</h2>
                    <span class="photos-count">{{ random_int(5, 20) }} photos</span>
                </div>
                <div class="photos-grid">
                    <div class="photo-thumbnail">
                        <img src="{{ asset('img/pharmacy-1.jpg') }}" alt="Photo 1" onerror="this.src='https://via.placeholder.com/300x300.jpg?text=Photo+1'">
                    </div>
                    <div class="photo-thumbnail">
                        <img src="{{ asset('img/pharmacy-2.jpg') }}" alt="Photo 2" onerror="this.src='https://via.placeholder.com/300x300.jpg?text=Photo+2'">
                    </div>
                    <div class="photo-thumbnail">
                        <img src="{{ asset('img/pharmacy-3.jpg') }}" alt="Photo 3" onerror="this.src='https://via.placeholder.com/300x300.jpg?text=Photo+3'">
                    </div>
                </div>
                <a href="#" class="link-all-photos">
                    <i class="fas fa-images"></i> Voir toutes les photos
                </a>
            </section>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($pharmacy->latitude && $pharmacy->longitude)
        const map = L.map('map').setView([{{ $pharmacy->latitude }}, {{ $pharmacy->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        const marker = L.marker([{{ $pharmacy->latitude }}, {{ $pharmacy->longitude }}])
            .addTo(map)
            .bindPopup("<b>{{ $pharmacy->name }}</b><br>{{ $pharmacy->address }}")
            .openPopup();
        @endif
    });
</script>
@endpush 