// JavaScript functionality for Pharmacy Locator

document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('searchInput');
    const searchLoader = document.getElementById('searchLoader');

    searchButton.addEventListener('click', function() {
        handleSearch();
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });

    function handleSearch() {
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm === '') {
            alert('Veuillez entrer un nom de médicament');
            return;
        }

        // Afficher le loader
        searchLoader.classList.remove('hidden');

        // Simuler un temps de chargement (à remplacer par votre vraie logique de recherche)
        setTimeout(() => {
            // Rediriger vers la page de recherche avec le terme recherché
            window.location.href = `search.html?q=${encodeURIComponent(searchTerm)}`;
        }, 1500); // 1.5 secondes de délai pour la démo
    }
});

// Placeholder for future features and interactions.