document.addEventListener('DOMContentLoaded', function() {
    // Initialisation de la carte
    const map = L.map('map').setView([48.8566, 2.3522], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ajouter un marqueur pour la pharmacie
    const pharmacyMarker = L.marker([48.8566, 2.3522])
        .addTo(map)
        .bindPopup('Pharmacie Centrale')
        .openPopup();

    // Gestion de la galerie photos
    const photosGrid = document.querySelector('.photos-grid');
    if (photosGrid) {
        // Simuler le chargement des photos
        const photos = [
            'pharmacy-1.jpg',
            'pharmacy-2.jpg',
            'pharmacy-3.jpg'
        ];

        photos.forEach(photo => {
            const img = document.createElement('div');
            img.className = 'photo-thumbnail';
            img.style.backgroundImage = `url(images/${photo})`;
            photosGrid.appendChild(img);
        });
    }
});
