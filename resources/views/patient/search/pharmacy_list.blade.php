@extends('layouts.patient')

@section('title', 'Liste des pharmacies')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    /* Mobile-first styles */
    .pharmacy-list {
        padding: 1rem;
        width: 100%;
        margin: 0 auto;
    }

    .pharmacy-list h1 {
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.25rem;
    }

    .pharmacy-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .pharmacy-card {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .pharmacy-card:hover {
        transform: translateY(-3px);
    }

    .pharmacy-name {
        color: var(--primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .pharmacy-info {
        color: #666;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .pharmacy-info p {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: flex-start;
    }

    .pharmacy-info i {
        width: 20px;
        color: var(--primary);
        margin-right: 0.5rem;
        margin-top: 0.2rem;
    }

    .pharmacy-actions {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .pharmacy-actions a {
        width: 100%;
        text-align: center;
        padding: 0.75rem 0.5rem;
        border-radius: 0.25rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .btn-details {
        background: var(--primary);
        color: var(--white);
    }

    .btn-details:hover {
        background: #0056b3;
    }

    .btn-directions {
        background: var(--white);
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-directions:hover {
        background: rgba(0, 123, 255, 0.1);
    }

    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 1.5rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: block;
        padding: 0.4rem 0.8rem;
        border-radius: 0.25rem;
        text-decoration: none;
        color: var(--primary);
        background: var(--white);
        transition: all 0.3s;
        font-size: 0.85rem;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
    }

    .pagination .page-link:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    /* No results message */
    .no-results {
        text-align: center;
        padding: 2rem;
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .no-results i {
        font-size: 2rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .no-results p {
        color: #666;
        margin-bottom: 1rem;
    }
    
    .no-results .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--primary);
        color: var(--white);
        border-radius: 0.25rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    /* Recherche et filtres styles */
    .search-section {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Styles pour l'intro de recherche */
    .search-intro {
        margin-bottom: 2rem;
    }

    .search-intro-title {
        color: var(--primary);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .search-intro-text {
        color: #666;
        font-size: 1rem;
        max-width: 800px;
        margin: 0 auto 1rem;
    }

    .search-section h2 {
        color: #333;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #444;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        font-size: 1rem;
        width: 100%;
    }

    .btn-primary {
        background: var(--secondary);
        color: var(--white);
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background 0.3s;
        display: block;
        width: 100%;
    }

    .btn-primary:hover {
        background: #218838;
    }

    .popular-searches {
        margin-top: 1.5rem;
    }

    .popular-searches h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .d-flex {
        display: flex;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .btn-outline-secondary {
        background: transparent;
        color: #6c757d;
        border: 1px solid #6c757d;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        text-decoration: none;
        transition: all 0.3s;
        font-size: 0.875rem;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: var(--white);
    }

    .categories-section {
        margin-top: 1.5rem;
    }

    .categories-section h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .category-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .category-card {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        text-decoration: none;
        border: 1px solid #eee;
    }

    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .category-card i {
        font-size: 1.75rem;
        color: var(--primary);
        margin-bottom: 0.75rem;
        display: block;
    }

    .category-card h4 {
        color: #333;
        font-size: 1rem;
        margin: 0;
    }

    /* Styles pour la section Comment ça marche */
    .how-it-works-section {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }

    .how-it-works-section h2 {
        color: #333;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
    }

    .steps-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem;
    }

    .step-number {
        width: 40px;
        height: 40px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .step-item h3 {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .step-item p {
        color: #666;
        font-size: 0.9rem;
        max-width: 250px;
    }

    /* Styles pour les résultats de recherche */
    .search-results-section {
        margin-bottom: 2rem;
    }

    .search-result {
        border-left: 3px solid var(--primary);
    }

    .medicines-found {
        margin-top: 1rem;
        background-color: rgba(0, 123, 255, 0.05);
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .medicines-found h3 {
        font-size: 1rem;
        color: var(--primary);
        margin-bottom: 0.75rem;
    }

    .medicines-found ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .medicines-found li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: space-between;
    }

    .medicines-found li:last-child {
        border-bottom: none;
    }

    .medicine-name {
        font-weight: 500;
        flex: 1;
        min-width: 150px;
    }

    .medicine-price {
        color: var(--primary);
        font-weight: 700;
    }

    .medicine-qty {
        color: #666;
        font-size: 0.85rem;
    }

    /* Styles pour la disposition en 2 colonnes */
    .two-columns-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .pharmacies-column {
        width: 100%;
    }

    .map-column {
        width: 100%;
        height: 300px;
        margin-bottom: 1.5rem;
    }

    #map {
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .section-title {
        text-align: center;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
    }

    /* Styles for the popup */
    .pharmacy-popup {
        font-size: 0.9rem;
    }

    .pharmacy-popup h3 {
        font-size: 1rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .pharmacy-popup p {
        margin: 0 0 0.25rem 0;
    }

    .pharmacy-popup-actions {
        margin-top: 0.5rem;
        display: flex;
        justify-content: space-between;
    }

    .pharmacy-popup-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        border-radius: 0.25rem;
        text-decoration: none;
        color: white;
        background-color: var(--primary);
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .pharmacy-list {
            padding: 2rem;
            max-width: 1200px;
        }
        
        .pharmacy-list h1 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .pharmacy-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .pharmacy-card {
            padding: 1.5rem;
            border-radius: 0.75rem;
        }
        
        .pharmacy-name {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .pharmacy-info {
            font-size: 1rem;
        }
        
        .pharmacy-actions {
            flex-direction: row;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .pharmacy-actions a {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        
        .pagination .page-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .input-group {
            flex-direction: row;
        }

        .btn-primary {
            width: auto;
        }
        
        .search-intro-title {
            font-size: 2rem;
        }
        
        .search-intro-text {
            font-size: 1.1rem;
        }

        .category-row {
            grid-template-columns: repeat(5, 1fr);
        }
        
        /* Styles pour la section Comment ça marche sur desktop */
        .steps-container {
            flex-direction: row;
            justify-content: space-between;
        }
        
        .step-item {
            flex: 1;
            padding: 0 1rem;
        }
        
        .step-number {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
        
        .step-item h3 {
            font-size: 1.2rem;
        }
        
        .step-item p {
            font-size: 1rem;
        }

        /* 2 colonnes en desktop */
        .two-columns-container {
            flex-direction: row;
        }

        .pharmacies-column {
            width: 50%;
        }

        .map-column {
            width: 50%;
            height: auto;
            min-height: 500px;
            position: sticky;
            top: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="pharmacy-list">
    <h1>Recherche vos médicaments</h1>

    <div class="search-section">
        <!-- Hero-like introduction -->
        <div class="search-intro mb-4 text-center">
            <h2 class="search-intro-title">Trouvez vos médicaments en quelques clics</h2>
            <p class="search-intro-text">Plus de recherches interminables de pharmacie en pharmacie. Localisez instantanément les médicaments dont vous avez besoin.</p>
        </div>
        
        <form action="{{ route('patient.search.results') }}" method="GET">
            <div class="form-group">
                <label for="query" class="form-label">Nom du médicament</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="query" name="query" placeholder="Entrez le nom d'un médicament..." value="{{ $searchQuery ?? '' }}" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </div>
        </form>
        
        <div class="popular-searches">
            <h3>Recherche populaire</h3>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('patient.search.results', ['query' => 'Paracétamol']) }}" class="btn btn-outline-secondary btn-sm">Paracétamol</a>
                <a href="{{ route('patient.search.results', ['query' => 'Ibuprofène']) }}" class="btn btn-outline-secondary btn-sm">Ibuprofène</a>
                <a href="{{ route('patient.search.results', ['query' => 'Aspirine']) }}" class="btn btn-outline-secondary btn-sm">Aspirine</a>
                <a href="{{ route('patient.search.results', ['query' => 'Doliprane']) }}" class="btn btn-outline-secondary btn-sm">Doliprane</a>
                <a href="{{ route('patient.search.results', ['query' => 'Amoxicilline']) }}" class="btn btn-outline-secondary btn-sm">Amoxicilline</a>
            </div>
        </div>
        
        <div class="categories-section">
            <h3>Explorer par catégorie</h3>
            <div class="category-row">
                <a href="{{ route('patient.search.results', ['category' => 'douleur']) }}" class="category-card">
                    <i class="fas fa-thermometer-half"></i>
                    <h4>Douleur et fièvre</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'digestion']) }}" class="category-card">
                    <i class="fas fa-pills"></i>
                    <h4>Digestion</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'rhume']) }}" class="category-card">
                    <i class="fas fa-head-side-cough"></i>
                    <h4>Rhume et grippe</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'allergie']) }}" class="category-card">
                    <i class="fas fa-wind"></i>
                    <h4>Allergies</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'sommeil']) }}" class="category-card">
                    <i class="fas fa-moon"></i>
                    <h4>Sommeil</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'vitamines']) }}" class="category-card">
                    <i class="fas fa-apple-alt"></i>
                    <h4>Vitamines</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'peau']) }}" class="category-card">
                    <i class="fas fa-allergies"></i>
                    <h4>Dermatologie</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'yeux']) }}" class="category-card">
                    <i class="fas fa-eye"></i>
                    <h4>Soins des yeux</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'cardiovasculaire']) }}" class="category-card">
                    <i class="fas fa-heartbeat"></i>
                    <h4>Cardiovasculaire</h4>
                </a>
                <a href="{{ route('patient.search.results', ['category' => 'antibiotiques']) }}" class="category-card">
                    <i class="fas fa-shield-virus"></i>
                    <h4>Antibiotiques</h4>
                </a>
            </div>
        </div>
    </div>

    <h2 class="section-title">Liste des pharmacies dans votre zone</h2>

    <div class="two-columns-container">
        <div class="pharmacies-column">
            @if(isset($searchResults) && $searchQuery)
            <div class="search-results-section">
                <h3 class="h4 mb-3">Résultats pour "{{ $searchQuery }}"</h3>
                
                @if($searchResults->count() > 0)
                    <div class="pharmacy-grid">
                        @foreach($searchResults as $result)
                            <div class="pharmacy-card search-result" data-lat="{{ $result['latitude'] }}" data-lng="{{ $result['longitude'] }}" data-id="{{ $result['id'] }}">
                                <h2 class="pharmacy-name">{{ $result['name'] }}</h2>
                                <div class="pharmacy-info">
                                    <p><i class="fas fa-map-marker-alt"></i> <span>{{ $result['address'] }}</span></p>
                                    <p><i class="fas fa-phone"></i> <span>{{ $result['phone_number'] }}</span></p>
                                    <p><i class="fas fa-pills"></i> <span>{{ $result['medicines']->count() }} médicaments trouvés</span></p>
                                </div>
                                
                                <div class="medicines-found">
                                    <h3>Médicaments disponibles</h3>
                                    <ul>
                                        @foreach($result['medicines'] as $medicine)
                                            <li>
                                                <span class="medicine-name">{{ $medicine['name'] }}</span>
                                                <span class="medicine-price">{{ $medicine['price'] }} FCFA</span>
                                                <span class="medicine-qty">({{ $medicine['quantity'] }} en stock)</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                                <div class="pharmacy-actions">
                                    <a href="{{ route('patient.search.pharmacy.details', $result['id']) }}" class="btn-details">
                                        <i class="fas fa-info-circle d-inline d-md-none me-1"></i>Voir les détails
                                    </a>
                                    @if($result['latitude'] && $result['longitude'])
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $result['latitude'] }},{{ $result['longitude'] }}" 
                                           target="_blank" 
                                           class="btn-directions">
                                            <i class="fas fa-directions d-inline d-md-none me-1"></i>Itinéraire
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>Aucun résultat trouvé pour "{{ $searchQuery }}".</p>
                        <p>Essayez d'autres termes de recherche ou explorez les catégories ci-dessus.</p>
                    </div>
                @endif
            </div>
            @else
                @if($pharmacies->count() > 0)
                    <div class="pharmacy-grid">
                        @foreach($pharmacies as $pharmacy)
                            <div class="pharmacy-card" data-lat="{{ $pharmacy->latitude }}" data-lng="{{ $pharmacy->longitude }}" data-id="{{ $pharmacy->id }}">
                                <h2 class="pharmacy-name">{{ $pharmacy->name }}</h2>
                                <div class="pharmacy-info">
                                    <p><i class="fas fa-map-marker-alt"></i> <span>{{ $pharmacy->address }}</span></p>
                                    <p><i class="fas fa-phone"></i> <span>{{ $pharmacy->phone_number }}</span></p>
                                    <p><i class="fas fa-pills"></i> <span>{{ $pharmacy->inventory_count }} médicaments en stock</span></p>
                                </div>
                                <div class="pharmacy-actions">
                                    <a href="{{ route('patient.search.pharmacy.details', $pharmacy->id) }}" class="btn-details">
                                        <i class="fas fa-info-circle d-inline d-md-none me-1"></i>Voir les détails
                                    </a>
                                    @if($pharmacy->latitude && $pharmacy->longitude)
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" 
                                           target="_blank" 
                                           class="btn-directions">
                                            <i class="fas fa-directions d-inline d-md-none me-1"></i>Itinéraire
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $pharmacies->links() }}
                @else
                    <div class="no-results">
                        <i class="fas fa-store-alt-slash"></i>
                        <p>Aucune pharmacie trouvée.</p>
                        <p>Essayez de rechercher un médicament spécifique pour trouver les pharmacies qui l'ont en stock.</p>
                    </div>
                @endif
            @endif
        </div>
        
        <div class="map-column">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser la carte
        const map = L.map('map').setView([6.3702, 2.3912], 13); // Coordonnées de Cotonou
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Ajouter les marqueurs des pharmacies
        const pharmacyCards = document.querySelectorAll('.pharmacy-card');
        const markers = [];
        
        pharmacyCards.forEach(function(card) {
            const lat = parseFloat(card.dataset.lat);
            const lng = parseFloat(card.dataset.lng);
            const id = card.dataset.id;
            
            if (!isNaN(lat) && !isNaN(lng)) {
                const name = card.querySelector('.pharmacy-name').textContent;
                const address = card.querySelector('.pharmacy-info span').textContent;
                
                const marker = L.marker([lat, lng]).addTo(map);
                
                // Créer le contenu du popup
                let popupContent = `
                    <div class="pharmacy-popup">
                        <h3>${name}</h3>
                        <p>${address}</p>
                        <div class="pharmacy-popup-actions">
                            <a href="/patient/pharmacy/${id}" class="pharmacy-popup-btn">Détails</a>
                        </div>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                
                // Ajouter l'événement click pour centrer la carte sur le marqueur
                card.addEventListener('click', function() {
                    map.setView([lat, lng], 15);
                    marker.openPopup();
                });
                
                markers.push(marker);
            }
        });
        
        // Ajuster la vue pour voir tous les marqueurs (s'il y en a)
        if (markers.length > 0) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds(), {
                padding: [50, 50]
            });
        }
        
        // Détecter la position de l'utilisateur
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                
                // Ajouter un marqueur pour la position de l'utilisateur
                const userIcon = L.divIcon({
                    className: 'user-location',
                    html: '<div style="background-color: #3388ff; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });
                
                L.marker([userLat, userLng], {icon: userIcon}).addTo(map)
                    .bindPopup('Votre position')
                    .openPopup();
                
                // Centrer la carte sur la position de l'utilisateur
                map.setView([userLat, userLng], 13);
            });
        }
    });
</script>
@endpush 