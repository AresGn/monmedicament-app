// Données fictives des pharmacies
const pharmaciesData = [
    {
        id: 1,
        name: "Pharmacie Centrale",
        lat: 6.3702928,
        lng: 2.3912362,
        address: "123 Boulevard Saint-Michel, Cotonou",
        phone: "+229 21 12 34 56",
        rating: 4.5,
        reviews: 128,
        openUntil: "20h00",
        distance: "800m",
        stock: {
            "Doliprane 1000mg": { price: 2435, available: true },
            "Paracétamol 500mg": { price: 1500, available: true },
            "Aspirine 500mg": { price: 5635, available: false }
        }
    },
    {
        id: 2,
        name: "Pharmacie du Marché",
        lat: 6.3652928,
        lng: 2.3892362,
        address: "45 Avenue Jean Bayol, Cotonou",
        phone: "+229 21 98 76 54",
        rating: 4.2,
        reviews: 95,
        openUntil: "22h00",
        distance: "1.2km",
        stock: {
            "Doliprane 1000mg": { price: 2400, available: true },
            "Aspirine 500mg": { price: 5500, available: true }
        }
    },
    {
        id: 3,
        name: "Pharmacie de la Paix",
        lat: 6.3722928,
        lng: 2.3942362,
        address: "78 Rue du Commerce, Cotonou",
        phone: "+229 21 45 67 89",
        rating: 4.8,
        reviews: 156,
        openUntil: "23h00",
        distance: "1.5km",
        stock: {
            "Paracétamol 500mg": { price: 1450, available: true },
            "Aspirine 500mg": { price: 5700, available: true }
        }
    }
];

document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le terme de recherche depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('q');

    if (searchTerm) {
        // Pré-remplir le champ de recherche
        const searchInput = document.querySelector('.search-bar input');
        if (searchInput) {
            searchInput.value = searchTerm;
        }

        // Filtrer les pharmacies selon le terme de recherche
        const filteredPharmacies = pharmaciesData.filter(pharmacy => 
            Object.keys(pharmacy.stock).some(med => 
                med.toLowerCase().includes(searchTerm.toLowerCase())
            )
        );

        // Afficher les résultats
        displayPharmacies(filteredPharmacies);
    }

    // Initialisation de la carte OpenStreetMap
    const map = L.map('map').setView([6.3702928, 2.3912362], 14); // Coordonnées de Cotonou

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ajouter les marqueurs des pharmacies
    pharmaciesData.forEach(pharmacy => {
        const marker = L.marker([pharmacy.lat, pharmacy.lng])
            .bindPopup(`
                <h3>${pharmacy.name}</h3>
                <p>${pharmacy.address}</p>
                <p>Téléphone: ${pharmacy.phone}</p>
            `)
            .addTo(map);
    });

    // Fonction pour afficher les pharmacies dans la liste
    function displayPharmacies(pharmacies) {
        const resultsList = document.querySelector('.results-list');
        resultsList.innerHTML = ''; // Vider la liste existante

        pharmacies.forEach(pharmacy => {
            const pharmacyCard = createPharmacyCard(pharmacy);
            resultsList.appendChild(pharmacyCard);
        });
    }

    // Créer une carte de pharmacie
    function createPharmacyCard(pharmacy) {
        const card = document.createElement('div');
        card.className = 'pharmacy-card';
        card.innerHTML = `
            <div class="pharmacy-header">
                <h3>${pharmacy.name}</h3>
                <div class="rating">
                    <span class="stars">★★★★★</span>
                    <span class="reviews">(${pharmacy.reviews} avis)</span>
                </div>
            </div>
            <div class="pharmacy-info">
                <p><i class="fas fa-map-marker-alt"></i> ${pharmacy.address}</p>
                <p><i class="fas fa-walking"></i> À ${pharmacy.distance}</p>
                <p><i class="fas fa-clock"></i> Ouvert jusqu'à ${pharmacy.openUntil}</p>
                <p><i class="fas fa-phone"></i> ${pharmacy.phone}</p>
            </div>
            <div class="stock-status in-stock">
                En stock
            </div>
            <div class="medicines-list">
                ${Object.entries(pharmacy.stock).map(([med, info]) => `
                    <div class="medicine-item">
                        <span>${med}</span>
                        <span class="price">${info.price}F / boîte</span>
                    </div>
                `).join('')}
            </div>
            <div class="action-buttons">
                <button class="btn-reserve">Réserver</button>
                <button class="btn-details" data-pharmacy-id="${pharmacy.id}">Plus de détails</button>
            </div>
        `;

        // Ajouter l'écouteur d'événement pour le bouton "Plus de détails"
        const detailsButton = card.querySelector('.btn-details');
        detailsButton.addEventListener('click', () => {
            window.location.href = `pharmacy-details.html?id=${pharmacy.id}`;
        });

        return card;
    }

    // Afficher les pharmacies initiales
    displayPharmacies(pharmaciesData);

    // Gestion des filtres
    document.querySelectorAll('.filter-group input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            applyFilters();
        });
    });

    // Simulation de la recherche
    const searchInput = document.querySelector('.search-bar input');
    const searchBtn = document.querySelector('.search-btn');
    
    searchBtn.addEventListener('click', () => {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredPharmacies = pharmaciesData.filter(pharmacy => 
            Object.keys(pharmacy.stock).some(med => 
                med.toLowerCase().includes(searchTerm)
            )
        );
        displayPharmacies(filteredPharmacies);
    });

    // Gestion des filtres
    const filterBtn = document.querySelector('.filter-btn');
    const filtersDropdown = document.querySelector('.filters-dropdown');
    const applyFiltersBtn = document.querySelector('.btn-apply-filters');
    const resetFiltersBtn = document.querySelector('.btn-reset-filters');

    filterBtn.addEventListener('click', () => {
        filtersDropdown.classList.toggle('hidden');
    });

    applyFiltersBtn.addEventListener('click', () => {
        applyFilters();
        filtersDropdown.classList.add('hidden');
    });

    resetFiltersBtn.addEventListener('click', () => {
        resetFilters();
    });

    function resetFilters() {
        document.querySelectorAll('.filter-group input[type="radio"][value="all"]').forEach(radio => {
            radio.checked = true;
        });
        applyFilters();
    }
});
