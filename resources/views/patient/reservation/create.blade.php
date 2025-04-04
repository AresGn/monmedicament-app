@extends('layouts.patient')

@section('title', 'Réservation de médicaments - ' . $pharmacy->name)

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

    /* Progress bar */
    .progress-bar {
        background-color: var(--white);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1rem;
        margin-bottom: 1.5rem;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .progress-content {
        display: flex;
        flex-direction: column;
        max-width: 1200px;
        margin: 0 auto;
        gap: 1.5rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        flex: 1;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .step.active .step-number {
        background-color: var(--primary);
        color: var(--white);
    }

    .step span {
        font-size: 0.85rem;
        color: var(--text-gray);
        text-align: center;
    }

    .step.active span {
        color: var(--primary);
        font-weight: 500;
    }

    .step-line {
        flex: 1;
        height: 2px;
        background-color: #e9ecef;
        margin: 0 0.5rem;
        position: relative;
        top: -16px;
        z-index: 0;
    }

    .step-line.active {
        background-color: var(--primary);
    }

    /* Main content */
    .booking-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 2rem;
    }

    .main-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Upload section */
    .upload-section, .additional-info, .pharmacy-info, .pickup-mode, .delivery-map-section, .important-note {
        background-color: var(--white);
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    h2 {
        font-size: 1.25rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1rem;
        background-color: var(--light-gray);
        transition: all 0.3s;
    }

    .upload-zone:hover, .upload-zone.dragover {
        border-color: var(--primary);
        background-color: rgba(0, 123, 255, 0.05);
    }

    .upload-zone i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
        display: block;
    }

    .upload-zone p {
        margin-bottom: 1.5rem;
        color: var(--text-gray);
    }

    .upload-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-upload, .btn-camera {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: 1px solid var(--primary);
        background: transparent;
        color: var(--primary);
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-upload:hover, .btn-camera:hover {
        background-color: var(--primary);
        color: var(--white);
    }

    .upload-info {
        font-size: 0.85rem;
        color: var(--text-gray);
        text-align: center;
    }

    /* Form groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        font-weight: 500;
    }

    textarea, input[type="text"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background-color: var(--light-gray);
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Pharmacy card */
    .pharmacy-card {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .pharmacy-image {
        width: 80px;
        height: 80px;
        border-radius: 0.25rem;
        overflow: hidden;
        background-color: #e9ecef;
        background-image: url('{{ asset('img/pharmacy-placeholder.jpg') }}');
        background-size: cover;
        background-position: center;
    }

    .pharmacy-details h3 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }

    .pharmacy-details p {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.25rem 0;
        color: var(--text-gray);
        font-size: 0.9rem;
    }

    /* Pickup options */
    .pickup-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .pickup-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .pickup-option:hover {
        border-color: var(--primary);
    }

    .pickup-option input {
        margin: 0;
    }

    /* Delivery map */
    #deliveryMap {
        height: 300px;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .delivery-info {
        margin-top: 1rem;
    }

    .estimated-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: var(--text-dark);
        font-weight: 600;
    }

    .delivery-address {
        display: flex;
        gap: 0.5rem;
    }

    .btn-confirm-address {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        white-space: nowrap;
    }

    /* Important note */
    .important-note {
        display: flex;
        gap: 1rem;
        background-color: rgba(255, 193, 7, 0.1);
        border-left: 4px solid var(--warning);
    }

    .important-note i {
        color: var(--warning);
        font-size: 1.5rem;
    }

    .important-note h3 {
        font-size: 1rem;
        margin-bottom: 0.25rem;
        color: var(--text-dark);
    }

    .important-note p {
        font-size: 0.9rem;
        color: var(--text-gray);
        margin: 0;
    }

    /* Continue button */
    .btn-continue {
        display: block;
        width: 100%;
        padding: 1rem;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 1.5rem;
    }

    .btn-continue:hover {
        background-color: #0069d9;
        transform: translateY(-2px);
    }

    /* Responsive design */
    @media (min-width: 768px) {
        .progress-content {
            flex-direction: row;
        }

        .main-grid {
            flex-direction: row;
        }

        .main-column {
            flex: 2;
        }

        .side-column {
            flex: 1;
        }
    }

    /* Medicines selection */
    .medicine-selection {
        margin-top: 2rem;
    }

    .medicine-list {
        margin-top: 1rem;
    }

    .medicine-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background-color: var(--light-gray);
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .medicine-info {
        flex: 1;
    }

    .medicine-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .medicine-price {
        color: var(--text-gray);
        font-size: 0.9rem;
    }

    .medicine-quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        padding: 0.5rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }

    .btn-quantity {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="progress-bar">
    <div class="progress-content">
        <a href="{{ route('patient.search.pharmacy.details', $pharmacy->id) }}" class="back-button">
            <i class="fas fa-chevron-left"></i>
            <span>Retour</span>
        </a>
        <div class="steps">
            <div class="step active">
                <div class="step-number">1</div>
                <span>Ordonnance</span>
            </div>
            <div class="step-line active"></div>
            <div class="step active">
                <div class="step-number">2</div>
                <span>Vérification</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span>Confirmation</span>
            </div>
        </div>
    </div>
</div>

<main class="booking-content">
    <form action="{{ route('patient.reservations.store') }}" method="POST" enctype="multipart/form-data" @guest onsubmit="alert('Veuillez vous connecter pour finaliser votre réservation.'); return false;" @endguest>
        @csrf
        <input type="hidden" name="pharmacy_id" value="{{ $pharmacy->id }}">

        <div class="main-grid">
            <div class="main-column">
                <section class="upload-section">
                    <h2>Votre ordonnance</h2>
                    <div class="upload-zone" id="dropZone">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Glissez-déposez votre ordonnance ici ou</p>
                        <div class="upload-buttons">
                            <button type="button" class="btn-upload" id="fileUploadBtn">
                                <i class="fas fa-file-upload"></i>
                                Importer un fichier
                            </button>
                            <button type="button" class="btn-camera" id="cameraCaptureBtn">
                                <i class="fas fa-camera"></i>
                                Prendre en photo
                            </button>
                        </div>
                        <input type="file" name="prescription_file" id="prescriptionFile" style="display: none;" accept="image/jpeg,image/png,application/pdf">
                        <input type="file" name="prescription_camera" id="prescriptionCamera" style="display: none;" accept="image/*" capture="environment">
                    </div>
                    <p class="upload-info">Formats acceptés : JPG, PNG, PDF - Max 10MB</p>
                </section>

                @if(count($medicines) > 0)
                <section class="medicine-selection">
                    <h2>Médicaments disponibles</h2>
                    <div class="medicine-list">
                        @foreach($medicines as $index => $medicine)
                        <div class="medicine-item">
                            <div class="medicine-info">
                                <div class="medicine-name">{{ $medicine['name'] }}</div>
                                <div class="medicine-price">{{ number_format($medicine['price'], 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="medicine-quantity">
                                <button type="button" class="btn-quantity decrease-qty"><i class="fas fa-minus"></i></button>
                                <input type="number" class="quantity-input" name="medicines[{{ $index }}][quantity]" value="0" min="0" max="{{ $medicine['max_quantity'] }}" data-max="{{ $medicine['max_quantity'] }}">
                                <button type="button" class="btn-quantity increase-qty"><i class="fas fa-plus"></i></button>
                                <input type="hidden" name="medicines[{{ $index }}][id]" value="{{ $medicine['id'] }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <section class="additional-info">
                    <h2>Informations complémentaires</h2>
                    <div class="form-group">
                        <label for="special_instructions">Instructions particulières</label>
                        <textarea id="special_instructions" name="special_instructions" placeholder="Ex: Allergie à certains génériques, préférence de marque..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="reservation_date">Date et heure souhaitées pour le retrait</label>
                        <input type="datetime-local" id="reservation_date" name="reservation_date" required min="{{ date('Y-m-d\TH:i', strtotime('+1 hour')) }}">
                    </div>
                </section>
            </div>

            <div class="side-column">
                <section class="pharmacy-info">
                    <h2>Pharmacie sélectionnée</h2>
                    <div class="pharmacy-card">
                        <div class="pharmacy-image"></div>
                        <div class="pharmacy-details">
                            <h3>{{ $pharmacy->name }}</h3>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $pharmacy->address }}</p>
                            <p><i class="far fa-clock"></i> Retrait possible sous 1h</p>
                        </div>
                    </div>
                </section>

                <section class="pickup-mode">
                    <h2>Mode de retrait</h2>
                    <div class="pickup-options">
                        <label class="pickup-option">
                            <input type="radio" name="pickup_mode" value="collect" checked>
                            <span>Click & Collect (Gratuit)</span>
                        </label>
                        <label class="pickup-option">
                            <input type="radio" name="pickup_mode" value="delivery">
                            <span>Livraison (+ 4.90€)</span>
                        </label>
                    </div>
                </section>

                <!-- Section de carte pour la livraison, visible uniquement quand livraison est sélectionnée -->
                <section class="delivery-map-section" id="deliverySection" style="display: none;">
                    <h2>Zone de livraison</h2>
                    <div id="deliveryMap"></div>
                    <div class="delivery-info">
                        <div class="estimated-time">
                            <i class="fas fa-clock"></i>
                            <span id="estimatedTime">--:--</span>
                        </div>
                        <div class="delivery-address">
                            <input type="text" id="deliveryAddress" name="delivery_address" placeholder="Entrez votre adresse de livraison">
                            <button type="button" id="confirmAddress" class="btn-confirm-address">
                                <i class="fas fa-check"></i> Confirmer
                            </button>
                        </div>
                    </div>
                </section>

                <div class="important-note">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <h3>Note importante</h3>
                        <p>L'ordonnance originale devra être présentée lors du retrait en pharmacie.</p>
                    </div>
                </div>

                @guest
                <div class="important-note" style="margin-top: 1.5rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <h3>Connexion requise pour finaliser la réservation</h3>
                        <p>Vous pourrez compléter et soumettre votre réservation après vous être connecté.</p>
                    </div>
                </div>

                <div class="auth-buttons" style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <a href="{{ route('patient.auth.login') }}?redirect={{ url()->full() }}" class="btn-continue" style="flex: 1; text-align: center; text-decoration: none;">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </a>
                    <a href="{{ route('patient.auth.register') }}?redirect={{ url()->full() }}" class="btn-continue" style="flex: 1; background-color: var(--secondary); text-align: center; text-decoration: none;">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </a>
                </div>
                @else
                <button type="submit" class="btn-continue">Continuer</button>
                @endguest
            </div>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Upload zone
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('prescriptionFile');
        const cameraInput = document.getElementById('prescriptionCamera');
        const fileUploadBtn = document.getElementById('fileUploadBtn');
        const cameraCaptureBtn = document.getElementById('cameraCaptureBtn');

        // Handle drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.classList.add('dragover');
        }

        function unhighlight() {
            dropZone.classList.remove('dragover');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Display selected file name
            if (files.length > 0) {
                const fileName = files[0].name;
                updateDropzoneText(fileName);
            }
        }

        // File selection buttons
        fileUploadBtn.addEventListener('click', () => {
            fileInput.click();
        });

        cameraCaptureBtn.addEventListener('click', () => {
            cameraInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                updateDropzoneText(fileName);
            }
        });

        cameraInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = "Photo prise";
                updateDropzoneText(fileName);
            }
        });

        function updateDropzoneText(fileName) {
            const p = dropZone.querySelector('p');
            p.textContent = `Fichier sélectionné : ${fileName}`;
        }

        // Delivery mode
        const pickupOptions = document.querySelectorAll('input[name="pickup_mode"]');
        const deliverySection = document.getElementById('deliverySection');
        
        pickupOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.value === 'delivery') {
                    deliverySection.style.display = 'block';
                    initMap();
                } else {
                    deliverySection.style.display = 'none';
                }
            });
        });

        // Map initialization
        let map, deliveryMarker;

        function initMap() {
            if (map) return; // Map already initialized
            
            // Initialize map with pharmacy location
            const pharmacyLat = {{ $pharmacy->latitude ?? 0 }};
            const pharmacyLng = {{ $pharmacy->longitude ?? 0 }};
            
            if (pharmacyLat && pharmacyLng) {
                map = L.map('deliveryMap').setView([pharmacyLat, pharmacyLng], 14);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Add pharmacy marker
                const pharmacyMarker = L.marker([pharmacyLat, pharmacyLng])
                    .addTo(map)
                    .bindPopup("{{ $pharmacy->name }}")
                    .openPopup();
                
                // Draw delivery radius (3km)
                const deliveryRadius = L.circle([pharmacyLat, pharmacyLng], {
                    color: '#007BFF',
                    fillColor: '#007BFF',
                    fillOpacity: 0.1,
                    radius: 3000 // 3km
                }).addTo(map);
                
                // Handle map click to set delivery location
                map.on('click', function(e) {
                    setDeliveryLocation(e.latlng);
                });
                
                // Confirm address button
                const confirmAddressBtn = document.getElementById('confirmAddress');
                confirmAddressBtn.addEventListener('click', function() {
                    const addressInput = document.getElementById('deliveryAddress');
                    const address = addressInput.value.trim();
                    
                    if (address) {
                        // In a real app, you would geocode the address here
                        // For now, we'll just show a success message
                        alert(`Adresse confirmée: ${address}`);
                        
                        // Update estimated time
                        document.getElementById('estimatedTime').textContent = "30-45 min";
                    } else {
                        alert('Veuillez entrer une adresse de livraison.');
                    }
                });
            }
        }
        
        function setDeliveryLocation(latlng) {
            // Remove existing marker if any
            if (deliveryMarker) {
                map.removeLayer(deliveryMarker);
            }
            
            // Add new marker
            deliveryMarker = L.marker(latlng)
                .addTo(map)
                .bindPopup("Votre position de livraison")
                .openPopup();
            
            // Calculate distance from pharmacy
            const pharmacyLat = {{ $pharmacy->latitude ?? 0 }};
            const pharmacyLng = {{ $pharmacy->longitude ?? 0 }};
            const distance = map.distance([pharmacyLat, pharmacyLng], [latlng.lat, latlng.lng]) / 1000; // km
            
            // Update estimated time based on distance
            let estimatedTime = "30-45 min";
            if (distance > 2) {
                estimatedTime = "45-60 min";
            }
            document.getElementById('estimatedTime').textContent = estimatedTime;
        }

        // Quantity controls
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const decreaseBtns = document.querySelectorAll('.decrease-qty');
        const increaseBtns = document.querySelectorAll('.increase-qty');

        decreaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                const input = quantityInputs[index];
                if (parseInt(input.value) > 0) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });

        increaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                const input = quantityInputs[index];
                const maxValue = parseInt(input.dataset.max);
                if (parseInt(input.value) < maxValue) {
                    input.value = parseInt(input.value) + 1;
                }
            });
        });
    });
</script>
@endpush 