document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    
    // Gestion du drag & drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('dragover');
    }

    function unhighlight(e) {
        dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        ([...files]).forEach(uploadFile);
    }

    function uploadFile(file) {
        // Vérification du type de fichier
        const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!validTypes.includes(file.type)) {
            alert('Format de fichier non supporté. Veuillez utiliser JPG, PNG ou PDF.');
            return;
        }

        // Vérification de la taille (10MB max)
        if (file.size > 10 * 1024 * 1024) {
            alert('Fichier trop volumineux. La taille maximum est de 10MB.');
            return;
        }

        // Simulation d'upload
        console.log('Upload du fichier:', file.name);
        // Ici vous pouvez ajouter le code pour envoyer le fichier au serveur
    }

    // Gestion du bouton d'upload
    const uploadButton = document.querySelector('.btn-upload');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.jpg,.jpeg,.png,.pdf';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    uploadButton.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFiles(e.target.files);
        }
    });

    // Gestion du bouton appareil photo
    const cameraButton = document.querySelector('.btn-camera');
    cameraButton.addEventListener('click', () => {
        // Vérifier si l'API est disponible
        if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
            // Ici vous pouvez ajouter le code pour accéder à la caméra
            console.log('Accès à la caméra demandé');
        } else {
            alert('Votre navigateur ne supporte pas l\'accès à la caméra');
        }
    });

    // Gestion du bouton continuer
    const continueButton = document.querySelector('.btn-continue');
    continueButton.addEventListener('click', () => {
        // Récupérer toutes les données nécessaires
        const pickupMode = document.querySelector('input[name="pickup"]:checked').value;
        const prescriptionFile = document.querySelector('.upload-zone').dataset.hasFile === 'true';
        
        // Créer l'objet de données de réservation
        const bookingData = {
            pharmacyName: "Pharmacie Centrale", // À remplacer par le nom réel
            pharmacyAddress: "123 rue Example", // À remplacer par l'adresse réelle
            prescriptionFile: prescriptionFile,
            pickupMode: pickupMode,
            pickupDate: new Date().toISOString(), // À remplacer par la date choisie
            pickupTime: "14:00", // À remplacer par l'heure choisie
        };

        // Si mode livraison, ajouter l'adresse
        if (pickupMode === 'delivery') {
            const deliveryAddress = document.getElementById('deliveryAddress').value;
            if (!deliveryAddress) {
                alert('Veuillez entrer une adresse de livraison');
                return;
            }
            bookingData.deliveryAddress = deliveryAddress;
        }

        // Sauvegarder les données dans localStorage
        localStorage.setItem('bookingData', JSON.stringify(bookingData));

        // Redirection vers la page de vérification
        window.location.href = 'verification.html';
    });

    // Variables pour la carte
    let deliveryMap = null;
    let deliveryRoute = null;
    const pharmacyPosition = [6.3702928, 2.3912362]; // Coordonnées de la pharmacie
    
    // Initialisation de la carte
    function initDeliveryMap() {
        if (!deliveryMap) {
            deliveryMap = L.map('deliveryMap').setView(pharmacyPosition, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(deliveryMap);

            // Marqueur de la pharmacie
            L.marker(pharmacyPosition)
                .bindPopup('Pharmacie Centrale')
                .addTo(deliveryMap);
        }
    }

    // Fonction pour calculer l'itinéraire
    async function calculateRoute(destinationAddress) {
        try {
            // Utilisation de l'API Nominatim pour géocoder l'adresse
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(destinationAddress)}`);
            const data = await response.json();

            if (data.length > 0) {
                const destination = [parseFloat(data[0].lat), parseFloat(data[0].lon)];

                // Suppression de l'ancien itinéraire s'il existe
                if (deliveryRoute) {
                    deliveryMap.removeLayer(deliveryRoute);
                }

                // Utilisation de l'API OSRM pour l'itinéraire
                const routeResponse = await fetch(`https://router.project-osrm.org/route/v1/driving/${pharmacyPosition[1]},${pharmacyPosition[0]};${destination[1]},${destination[0]}?overview=full&geometries=geojson`);
                const routeData = await routeResponse.json();

                if (routeData.routes && routeData.routes.length > 0) {
                    // Affichage de l'itinéraire
                    deliveryRoute = L.geoJSON(routeData.routes[0].geometry).addTo(deliveryMap);
                    
                    // Ajustement de la vue
                    deliveryMap.fitBounds(deliveryRoute.getBounds(), { padding: [50, 50] });

                    // Marqueur de destination
                    L.marker(destination)
                        .bindPopup('Point de livraison')
                        .addTo(deliveryMap);

                    // Calcul et affichage du temps estimé
                    const duration = Math.round(routeData.routes[0].duration / 60);
                    document.getElementById('estimatedTime').textContent = 
                        `Temps estimé: ${duration} minutes`;

                    return true;
                }
            }
            return false;
        } catch (error) {
            console.error('Erreur lors du calcul de l\'itinéraire:', error);
            return false;
        }
    }

    // Gestion du changement de mode de retrait
    document.querySelectorAll('input[name="pickup"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const deliveryMapSection = document.querySelector('.delivery-map-section');
            
            if (this.value === 'delivery') {
                deliveryMapSection.style.display = 'block';
                initDeliveryMap();
                deliveryMap.invalidateSize();
            } else {
                deliveryMapSection.style.display = 'none';
            }
        });
    });

    // Gestion de la confirmation d'adresse
    document.getElementById('confirmAddress').addEventListener('click', async function() {
        const addressInput = document.getElementById('deliveryAddress');
        const address = addressInput.value.trim();

        if (address) {
            const success = await calculateRoute(address);
            if (!success) {
                alert('Adresse non trouvée. Veuillez vérifier et réessayer.');
            }
        } else {
            alert('Veuillez entrer une adresse de livraison.');
        }
    });

    // Gestion de la saisie d'adresse avec la touche Enter
    document.getElementById('deliveryAddress').addEventListener('keypress', async function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('confirmAddress').click();
        }
    });
});
