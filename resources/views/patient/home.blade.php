@extends('layouts.patient')

@section('title', 'Accueil')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    /* Styles mobile-first */
    .hero {
        background: linear-gradient(135deg, #0D9488 0%, #0EA5E9 100%);
        color: var(--white);
        text-align: center;
        padding: 2rem 1rem;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
    }
    
    .hero-content {
        width: 100%;
        max-width: 1200px;
    }

    .hero h1 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
        width: 100%;
    }

    .hero p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
        line-height: 1.4;
        width: 100%;
    }

    .search-bar {
        width: 100%;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .search-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    .search-input-container {
        display: flex;
        width: 100%;
        gap: 0.5rem;
        box-sizing: border-box;
    }

    .search-input-container input {
        flex-grow: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 0.25rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .search-button {
        background: var(--secondary);
        color: var(--white);
        border: none;
        border-radius: 0.25rem;
        padding: 0 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        min-width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .search-button:hover {
        background-color: #218838;
    }

    .search-divider {
        position: relative;
        text-align: center;
        margin: 1rem 0;
    }

    .search-divider span {
        display: inline-block;
        padding: 0 0.75rem;
        background: var(--primary);
        color: white;
        font-weight: bold;
        position: relative;
        z-index: 1;
        border-radius: 20px;
        font-size: 0.8rem;
    }

    .search-divider:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .ordonnance-upload {
        background: white;
        border-radius: 0.25rem;
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    .ordonnance-upload h3 {
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
        text-align: left;
        width: 100%;
    }

    .drop-area {
        border: 2px dashed #ddd;
        border-radius: 0.25rem;
        padding: 1.5rem 1rem;
        text-align: center;
        position: relative;
        transition: all 0.3s;
        background: #f9f9f9;
        width: 100%;
        box-sizing: border-box;
    }

    .drop-area:hover, .drop-area.dragover {
        border-color: var(--primary);
        background: #f0f9ff;
    }

    .drop-icon {
        margin-bottom: 0.75rem;
    }

    .drop-icon i {
        font-size: 2rem;
        color: #666;
    }

    .drop-area p {
        margin-bottom: 0.75rem;
        color: #666;
        font-size: 0.9rem;
    }

    .upload-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .upload-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 600;
        font-size: 0.9rem;
        width: 100%;
    }

    .upload-btn:first-child {
        background: #0D9488;
        color: white;
    }

    .camera-btn {
        background: #0EA5E9;
        color: white;
    }

    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .file-formats {
        font-size: 0.7rem;
        color: #888;
        margin-top: 0.75rem;
    }

    .file-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #e6f7ff;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        margin: 0.75rem 0;
        border: 1px solid #0EA5E9;
        font-size: 0.85rem;
    }

    .file-info p {
        margin: 0;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-info p i {
        color: #0EA5E9;
    }

    .remove-file {
        background: none;
        border: none;
        color: #ff4d4f;
        cursor: pointer;
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .hero {
            padding: 4rem 2rem;
            width: 100%;
        }

        .hero-content {
            max-width: 1200px;
            width: 100%;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .search-options {
            gap: 2rem;
            width: 100%;
        }

        .search-input-container {
            gap: 1rem;
            width: 100%;
        }

        .search-input-container input {
            padding: 1rem;
            font-size: 1rem;
            flex: 1;
        }

        .search-button {
            padding: 0 2rem;
            min-width: 150px;
        }

        .ordonnance-upload {
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 100%;
        }

        .ordonnance-upload h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .drop-area {
            padding: 2rem;
            border-radius: 0.5rem;
            width: 100%;
        }

        .drop-icon i {
            font-size: 2.5rem;
        }

        .drop-area p {
            font-size: 1rem;
        }

        .upload-buttons {
            flex-direction: row;
            justify-content: center;
        }

        .upload-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
        }

        .file-formats {
            font-size: 0.8rem;
        }

        .file-info {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Grands téléphones et tablettes compactes */
    @media (min-width: 480px) and (max-width: 767px) {
        .hero {
            padding: 3rem 1.5rem;
        }
        
        .hero h1 {
            font-size: 2rem;
        }
        
        .hero p {
            font-size: 1.1rem;
        }
        
        .search-input-container {
            display: flex;
            width: 100%;
        }
        
        .search-input-container input {
            flex: 1;
        }
        
        .search-button {
            width: auto;
            min-width: 120px;
        }
    }

    .how-it-works {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .how-it-works h2 {
        color: #333;
        font-size: 2rem;
        margin-bottom: 3rem;
        position: relative;
    }

    .steps-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    .step-card {
        background: var(--neutral);
        padding: 2rem;
        border-radius: 1rem;
        flex: 1;
        position: relative;
        transition: transform 0.3s;
        max-width: 300px;
    }

    .step-card:hover {
        transform: translateY(-5px);
    }

    .step-icon {
        width: 80px;
        height: 80px;
        background: var(--white);
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .step-icon i {
        font-size: 2rem;
        color: var(--primary);
    }

    .step-number {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        background: var(--primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .step-card h3 {
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .step-card p {
        color: #666;
        line-height: 1.5;
    }

    .features {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .features h2 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .features > p {
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .features-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: var(--neutral);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        flex: 1;
        min-width: 300px;
        max-width: 350px;
        border: 2px solid var(--primary);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        border-color: var(--secondary);
    }

    .feature-card i {
        color: var(--secondary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .feature-card p {
        color: var(--primary);
        font-size: 1.1rem;
        line-height: 1.5;
    }

    .why-choose-us {
        padding: 5rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .why-choose-us h2 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .why-choose-us p {
        color: #666;
        margin-bottom: 2rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
    }

    .button-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 3rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .choice-btn {
        flex: 1;
        padding: 1rem;
        font-size: 1rem;
        border: none;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .choice-btn.active {
        background: var(--primary);
        color: var(--white);
    }

    .cards-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .why-card {
        background: #fff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        flex: 1;
        min-width: 250px;
        max-width: 350px;
        text-align: left;
        border: 1px solid #f0f0f0;
    }

    .why-card:hover {
        transform: translateY(-5px);
    }

    .why-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .why-icon i {
        font-size: 1.5rem;
        color: var(--error);
    }

    .why-card h3 {
        color: #333;
        font-size: 1.3rem;
        margin-bottom: 1rem;
    }

    .why-card p {
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 0;
        text-align: left;
    }

    .testimonials {
        padding: 6rem 2rem;
        background: var(--white);
    }

    .testimonials h2 {
        text-align: center;
        color: #333;
        font-size: 2.5rem;
        margin-bottom: 3rem;
    }

    .testimonials-container {
        display: flex;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
        justify-content: center;
    }

    .testimonial-card {
        background: var(--neutral);
        border-radius: 1rem;
        padding: 2rem;
        flex: 1;
        min-width: 300px;
        max-width: 380px;
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
    }

    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
    }

    .testimonial-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-content {
        text-align: center;
    }

    .quote-icon {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .testimonial-text {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .testimonial-author {
        margin-top: 1rem;
    }

    .testimonial-author strong {
        display: block;
        color: #333;
        font-size: 1.1rem;
    }

    .author-location {
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .steps-container {
            flex-direction: column;
            align-items: center;
        }

        .step-card {
            width: 100%;
            max-width: 100%;
        }

        .search-bar {
            flex-direction: column;
            padding: 0;
            width: 100%;
        }

        .search-input-container {
            width: 100%;
        }

        .search-input-container input {
            width: 100%;
        }

        .ordonnance-upload {
            width: 100%;
        }
        
        .drop-area {
            width: 100%;
        }

        .cards-container {
            flex-direction: column;
            align-items: center;
        }
        
        .why-card {
            width: 100%;
            max-width: 100%;
        }
    }

    /* Search Results Styles */
    .search-results {
        width: 100%;
        box-sizing: border-box;
        padding: 1rem;
        background: #f7f9fc;
    }

    .search-results-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .search-results-header h2 {
        font-size: 1.25rem;
        color: var(--primary);
        margin: 0;
    }

    .filter-button {
        background: white;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .filter-button:hover {
        background: #f0f0f0;
    }

    .search-results-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .pharmacy-list {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1rem;
        flex: 1;
    }

    .pharmacy-card {
        border-bottom: 1px solid #eee;
        padding: 1rem 0;
        margin-bottom: 1rem;
    }

    .pharmacy-card:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .pharmacy-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .pharmacy-details {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .pharmacy-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .pharmacy-info-item i {
        color: var(--primary);
        font-size: 0.9rem;
        margin-top: 0.2rem;
    }

    .pharmacy-distance {
        font-weight: 500;
        color: #666;
    }

    .pharmacy-address, .pharmacy-hours {
        color: #666;
        font-size: 0.9rem;
    }

    .medicine-list {
        background: #f9f9f9;
        border-radius: 0.25rem;
        padding: 0.75rem;
        margin: 0.75rem 0;
    }

    .medicine-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .medicine-item:last-child {
        border-bottom: none;
    }

    .medicine-name {
        font-weight: 500;
    }

    .medicine-price {
        color: var(--primary);
        font-weight: 500;
    }

    .stock-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .in-stock {
        background: rgba(40, 167, 69, 0.1);
        color: var(--secondary);
    }

    .pharmacy-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-details {
        background: var(--primary);
        color: white;
    }

    .btn-reserve {
        background: var(--secondary);
        color: white;
    }

    .btn-action:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .map-container {
        height: 300px;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .search-results {
            padding: 2rem;
        }

        .search-results-header h2 {
            font-size: 1.5rem;
        }

        .search-results-content {
            flex-direction: row;
            gap: 2rem;
        }

        .pharmacy-list {
            max-width: 60%;
            padding: 1.5rem;
        }

        .map-container {
            flex: 1;
            height: auto;
            min-height: 500px;
        }

        .pharmacy-details {
            grid-template-columns: repeat(2, 1fr);
        }

        .pharmacy-actions {
            justify-content: flex-start;
        }

        .btn-action {
            padding: 0.5rem 1.25rem;
        }
    }
</style>
@endpush

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h1>Trouvez vos médicaments en quelques clics</h1>
            <p>Localisez rapidement les pharmacies ayant vos médicaments en stock</p>
            <form action="#" method="GET" class="search-bar" enctype="multipart/form-data">
                <div class="search-options">
                    <div class="search-input-container">
                        <input type="text" name="query" id="searchInput" placeholder="Entrez les noms de vos médicaments (Ex: Paracétamol 200mg)..." required>
                        <button type="submit" class="search-button">Rechercher</button>
                    </div>

                    <div class="search-divider">
                        <span>OU</span>
                    </div>

                    <div class="ordonnance-upload">
                        <h3>Votre ordonnance</h3>
                        <div class="drop-area" id="dropArea">
                            <div class="drop-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p>Glissez-déposez votre ordonnance ici ou</p>
                            <div class="upload-buttons">
                                <label for="fileUpload" class="upload-btn">
                                    <i class="fas fa-file-upload"></i>
                                    Importer un fichier
                                </label>
                                <label for="cameraCapture" class="upload-btn camera-btn">
                                    <i class="fas fa-camera"></i>
                                    Prendre en photo
                                </label>
                            </div>
                            <input type="file" id="fileUpload" name="ordonnance" accept=".jpg,.jpeg,.png,.pdf" style="display: none;">
                            <input type="file" id="cameraCapture" name="ordonnance" accept="image/*" capture="camera" style="display: none;">
                            <p class="file-formats">Formats acceptés : JPG, PNG, PDF - Max 10MB</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Search Results Section - Initially Hidden -->
    <section id="searchResultsSection" class="search-results" style="display: none;">
        <div class="search-results-container">
            <div class="search-results-header">
                <h2>Résultats de recherche</h2>
                <button id="filtersButton" class="filter-button">Filtres</button>
            </div>

            <div class="search-results-content">
                <!-- Left Column: Pharmacy List -->
                <div class="pharmacy-list">
                    <div id="pharmacyResults">
                        <!-- Pharmacy results will be populated here dynamically -->
                    </div>
                </div>
                
                <!-- Right Column: Map -->
                <div class="map-container">
                    <div id="resultsMap" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="how-it-works">
        <h2>Comment ça marche ?</h2>
        <div class="steps-container">
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-search"></i>
                    <span class="step-number">1</span>
                </div>
                <h3>Recherchez</h3>
                <p>Saisissez le nom de votre médicament ou scannez votre ordonnance.</p>
            </div>

            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-map-marked-alt"></i>
                    <span class="step-number">2</span>
                </div>
                <h3>Localisez</h3>
                <p>Trouvez les pharmacies les plus proches ayant votre médicament en stock.</p>
            </div>

            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                    <span class="step-number">3</span>
                </div>
                <h3>Obtenez</h3>
                <p>Contactez la pharmacie ou suivez l'itinéraire pour récupérer votre traitement.</p>
            </div>
        </div>
    </section>

    <section class="why-choose-us">
        <h2>Pourquoi choisir MonMedicament ?</h2>
        <p>Découvrez comment MonMedicament transforme votre expérience de recherche de médicaments et vous fait gagner du temps et de l'énergie.</p>
        
        <div class="button-container">
            <button class="choice-btn active" id="sans-btn">Sans MonMedicament</button>
            <button class="choice-btn" id="avec-btn">Avec MonMedicament</button>
        </div>

        <div class="cards-container">
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-walking"></i>
                </div>
                <h3>Déplacements multiples</h3>
                <p>Vous devez vous déplacer dans plusieurs pharmacies avant de trouver vos médicaments, souvent sans résultat.</p>
            </div>
            
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <h3>Perte de temps</h3>
                <p>Des heures perdues en déplacements et appels téléphoniques pour localiser vos médicaments urgents.</p>
            </div>
            
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3>Stress et frustration</h3>
                <p>Situation particulièrement stressante en cas d'urgence médicale ou pour les personnes à mobilité réduite.</p>
            </div>
        </div>
    </section>

    <section class="features">
        <h2>Fonctionnalités</h2>
        <p>Découvrez comment MonMedicament peut vous aider à trouver vos médicaments rapidement.</p>
        <div class="features-container">
            <div class="feature-card">
                <i class="fas fa-map-marker-alt"></i>
                <p>Trouvez les pharmacies les plus proches de vous en temps réel</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-check-circle"></i>
                <p>Vérifiez la disponibilité des médicaments avant de vous déplacer</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-phone"></i>
                <p>Contactez directement la pharmacie de votre choix</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2>Ce que nos utilisateurs disent</h2>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Alice D.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">Grâce à MonMedicament, j'ai trouvé mon médicament en moins de 10 minutes. Très pratique !</p>
                    <div class="testimonial-author">
                        <strong>Alice D.</strong>
                        <span class="author-location">Cotonou, Bénin</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Jean K.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">Je recommande cette application à tous ceux qui cherchent des médicaments rapidement.</p>
                    <div class="testimonial-author">
                        <strong>Jean K.</strong>
                        <span class="author-location">Porto-Novo, Bénin</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Fatou M.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">MonMedicament m'a sauvé la vie lors d'une urgence médicale. Merci !</p>
                    <div class="testimonial-author">
                        <strong>Fatou M.</strong>
                        <span class="author-location">Parakou, Bénin</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.search-bar');
        const searchInput = document.getElementById('searchInput');
        const dropArea = document.getElementById('dropArea');
        const fileUpload = document.getElementById('fileUpload');
        const cameraCapture = document.getElementById('cameraCapture');
        const searchResultsSection = document.getElementById('searchResultsSection');
        const pharmacyResults = document.getElementById('pharmacyResults');
        const filtersButton = document.getElementById('filtersButton');
        let map = null;
        let markers = [];

        // Initialize the map
        function initMap() {
            if (map === null) {
                map = L.map('resultsMap').setView([6.3702, 2.3912], 13); // Cotonou coordinates
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            }
            return map;
        }

        // Clear existing markers from the map
        function clearMarkers() {
            if (markers.length > 0) {
                markers.forEach(marker => map.removeLayer(marker));
                markers = [];
            }
        }

        // Add markers for pharmacies to the map
        function addPharmacyMarkers(pharmacies) {
            clearMarkers();
            
            pharmacies.forEach(pharmacy => {
                if (pharmacy.latitude && pharmacy.longitude) {
                    const marker = L.marker([pharmacy.latitude, pharmacy.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <strong>${pharmacy.name}</strong><br>
                            ${pharmacy.address}<br>
                            <a href="tel:${pharmacy.phone_number}">${pharmacy.phone_number}</a>
                        `);
                    
                    markers.push(marker);
                }
            });
            
            // If we have markers, fit the map to show all markers
            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        // Render pharmacy results in HTML
        function renderPharmacyResults(pharmacies) {
            if (pharmacies.length === 0) {
                pharmacyResults.innerHTML = `
                    <div class="no-results">
                        <p>Aucun résultat trouvé pour cette recherche.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            
            pharmacies.forEach(pharmacy => {
                let medicinesHtml = '';
                
                pharmacy.medicines.forEach(medicine => {
                    medicinesHtml += `
                        <div class="medicine-item">
                            <span class="medicine-name">${medicine.name}
                                <span class="stock-badge in-stock">En stock</span>
                            </span>
                            <span class="medicine-price">${medicine.price} FCFA</span>
                        </div>
                    `;
                });
                
                html += `
                    <div class="pharmacy-card">
                        <h3 class="pharmacy-name">${pharmacy.name}</h3>
                        <div class="pharmacy-details">
                            <div class="pharmacy-info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="pharmacy-distance">À 800m</span>
                            </div>
                            <div class="pharmacy-info-item">
                                <i class="fas fa-location-arrow"></i>
                                <span class="pharmacy-address">${pharmacy.address}</span>
                            </div>
                            <div class="pharmacy-info-item">
                                <i class="fas fa-clock"></i>
                                <span class="pharmacy-hours">Ouvert jusqu'à 20h00</span>
                            </div>
                            <div class="pharmacy-info-item">
                                <i class="fas fa-phone"></i>
                                <span class="pharmacy-phone">${pharmacy.phone_number}</span>
                            </div>
                        </div>
                        
                        <div class="medicine-list">
                            ${medicinesHtml}
                        </div>
                        
                        <div class="pharmacy-actions">
                            <a href="${pharmacy.id}" class="btn-action btn-details">
                                <i class="fas fa-info-circle mr-1"></i> Détails
                            </a>
                            <a href="${pharmacy.id}" class="btn-action btn-reserve">
                                <i class="fas fa-calendar-check mr-1"></i> Réserver
                            </a>
                        </div>
                    </div>
                `;
            });
            
            pharmacyResults.innerHTML = html;
        }

        // Perform the search and show results
        function performSearch(query) {
            // Show loading state
            pharmacyResults.innerHTML = '<div class="loading">Recherche en cours...</div>';
            searchResultsSection.style.display = 'block';
            
            // Initialize map
            initMap();
            
            // AJAX request to get search results
            fetch(`/api/medicines/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    renderPharmacyResults(data.pharmacies);
                    addPharmacyMarkers(data.pharmacies);
                    
                    // Scroll to results
                    searchResultsSection.scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    pharmacyResults.innerHTML = `
                        <div class="error">
                            <p>Une erreur s'est produite lors de la recherche. Veuillez réessayer.</p>
                        </div>
                    `;
                });
        }

        // Handle search form submission
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission
            const query = searchInput.value.trim();
            const hasFile = fileUpload.files.length > 0 || cameraCapture.files.length > 0;
            
            if (!query && !hasFile) {
                alert('Veuillez entrer le nom d\'un médicament ou importer une ordonnance.');
                searchInput.focus();
                return;
            }
            
            if (query) {
                performSearch(query);
            } else if (hasFile) {
                // Handle file upload - not implemented in this version
                alert('La recherche par ordonnance sera disponible prochainement.');
            }
        });

        // Filters button functionality (to be implemented later)
        if (filtersButton) {
            filtersButton.addEventListener('click', function() {
                alert('Les filtres seront disponibles prochainement.');
            });
        }

        // Gestion du drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('dragover');
        }

        function unhighlight() {
            dropArea.classList.remove('dragover');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileUpload.files = files;
                updateFileInfo(fileUpload.files[0]);
            }
        }

        // Afficher le nom du fichier sélectionné
        fileUpload.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });

        cameraCapture.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });

        function updateFileInfo(file) {
            if (file) {
                // Vérifier la taille du fichier (max 10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB en octets
                if (file.size > maxSize) {
                    alert('Le fichier est trop volumineux. Veuillez sélectionner un fichier de moins de 10MB.');
                    return;
                }

                // Créer un élément pour afficher le nom du fichier
                const fileInfo = document.createElement('div');
                fileInfo.className = 'file-info';
                fileInfo.innerHTML = `
                    <p><i class="fas fa-file"></i> ${file.name}</p>
                    <button type="button" class="remove-file"><i class="fas fa-times"></i></button>
                `;

                // Remplacer le contenu de la zone de dépôt
                const existingInfo = dropArea.querySelector('.file-info');
                if (existingInfo) {
                    dropArea.removeChild(existingInfo);
                }
                
                // Cacher les éléments d'upload
                const elementsToHide = dropArea.querySelectorAll('.drop-icon, .drop-area > p:not(.file-formats), .upload-buttons');
                elementsToHide.forEach(el => el.style.display = 'none');
                
                // Ajouter l'info du fichier
                dropArea.insertBefore(fileInfo, dropArea.querySelector('.file-formats'));
                
                // Ajouter un gestionnaire pour supprimer le fichier
                const removeButton = fileInfo.querySelector('.remove-file');
                removeButton.addEventListener('click', function() {
                    fileUpload.value = '';
                    cameraCapture.value = '';
                    dropArea.removeChild(fileInfo);
                    
                    // Réafficher les éléments d'upload
                    elementsToHide.forEach(el => el.style.display = '');
                });
            }
        }

        // Pourquoi Nous Choisir buttons functionality
        const sansBtn = document.getElementById('sans-btn');
        const avecBtn = document.getElementById('avec-btn');
        const whyCards = document.querySelectorAll('.why-card');

        if (sansBtn && avecBtn) {
            sansBtn.addEventListener('click', function() {
                sansBtn.classList.add('active');
                avecBtn.classList.remove('active');
                
                // Change content for "Sans" state
                updateCardsForSansState();
            });

            avecBtn.addEventListener('click', function() {
                avecBtn.classList.add('active');
                sansBtn.classList.remove('active');
                
                // Change content for "Avec" state
                updateCardsForAvecState();
            });

            // Default state - Sans MonMedicament
            updateCardsForSansState();
        }

        function updateCardsForAvecState() {
            if (whyCards.length >= 3) {
                // First card - Localisation précise
                whyCards[0].querySelector('h3').textContent = 'Localisation précise';
                whyCards[0].querySelector('p').textContent = 'Trouvez immédiatement les pharmacies ayant vos médicaments en stock sans vous déplacer inutilement.';
                whyCards[0].querySelector('.why-icon i').className = 'fas fa-map-marker-alt';
                whyCards[0].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[0].querySelector('.why-icon i').style.color = 'var(--secondary)';
                
                // Second card - Gain de temps
                whyCards[1].querySelector('h3').textContent = 'Gain de temps';
                whyCards[1].querySelector('p').textContent = 'Économisez des heures précieuses en consultant les disponibilités en temps réel depuis votre smartphone.';
                whyCards[1].querySelector('.why-icon i').className = 'fas fa-clock';
                whyCards[1].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[1].querySelector('.why-icon i').style.color = 'var(--secondary)';
                
                // Third card - Tranquillité d'esprit
                whyCards[2].querySelector('h3').textContent = 'Tranquillité d\'esprit';
                whyCards[2].querySelector('p').textContent = 'Accédez rapidement à vos traitements, même en situation d\'urgence ou à mobilité réduite.';
                whyCards[2].querySelector('.why-icon i').className = 'fas fa-check-circle';
                whyCards[2].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[2].querySelector('.why-icon i').style.color = 'var(--secondary)';
            }
        }

        function updateCardsForSansState() {
            if (whyCards.length >= 3) {
                // First card - Déplacements multiples
                whyCards[0].querySelector('h3').textContent = 'Déplacements multiples';
                whyCards[0].querySelector('p').textContent = 'Vous devez vous déplacer dans plusieurs pharmacies avant de trouver vos médicaments, souvent sans résultat.';
                whyCards[0].querySelector('.why-icon i').className = 'fas fa-walking';
                whyCards[0].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[0].querySelector('.why-icon i').style.color = 'var(--error)';
                
                // Second card - Perte de temps
                whyCards[1].querySelector('h3').textContent = 'Perte de temps';
                whyCards[1].querySelector('p').textContent = 'Des heures perdues en déplacements et appels téléphoniques pour localiser vos médicaments urgents.';
                whyCards[1].querySelector('.why-icon i').className = 'fas fa-hourglass-half';
                whyCards[1].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[1].querySelector('.why-icon i').style.color = 'var(--error)';
                
                // Third card - Stress et frustration
                whyCards[2].querySelector('h3').textContent = 'Stress et frustration';
                whyCards[2].querySelector('p').textContent = 'Situation particulièrement stressante en cas d\'urgence médicale ou pour les personnes à mobilité réduite.';
                whyCards[2].querySelector('.why-icon i').className = 'fas fa-exclamation-circle';
                whyCards[2].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[2].querySelector('.why-icon i').style.color = 'var(--error)';
            }
        }
    });
</script>
@endpush 