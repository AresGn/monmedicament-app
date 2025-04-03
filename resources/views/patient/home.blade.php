@extends('layouts.patient')

@section('title', 'Accueil')

@push('styles')
<style>
    /* Styles mobile-first */
    .hero {
        background: linear-gradient(135deg, #0D9488 0%, #0EA5E9 100%);
        color: var(--white);
        text-align: center;
        padding: 2rem 1rem;
    }

    .hero h1 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .hero p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
        line-height: 1.4;
    }

    .search-bar {
        width: 100%;
        margin: 0 auto;
    }

    .search-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
    }

    .search-input-container {
        display: flex;
        width: 100%;
        gap: 0.5rem;
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
    }

    .ordonnance-upload h3 {
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
        text-align: left;
    }

    .drop-area {
        border: 2px dashed #ddd;
        border-radius: 0.25rem;
        padding: 1.5rem 1rem;
        text-align: center;
        position: relative;
        transition: all 0.3s;
        background: #f9f9f9;
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
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .search-bar {
            max-width: 800px;
        }

        .search-options {
            gap: 2rem;
        }

        .search-input-container {
            gap: 1rem;
        }

        .search-input-container input {
            padding: 1rem;
            font-size: 1rem;
        }

        .search-button {
            padding: 0 2rem;
        }

        .ordonnance-upload {
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        .ordonnance-upload h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .drop-area {
            padding: 2rem;
            border-radius: 0.5rem;
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
        background: var(--neutral);
    }

    .why-choose-us h2 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 2rem;
    }

    .why-choose-us p {
        color: #666;
        margin-bottom: 3rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
    }

    .comparison-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto 3rem;
    }

    .comparison-button {
        flex: 1;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        max-width: 400px;
    }

    .without-btn {
        background: #f8d7da;
        border: 2px solid var(--error);
        color: #721c24;
    }

    .with-btn {
        background: #d4edda;
        border: 2px solid var(--secondary);
        color: #155724;
    }

    .comparison-button h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .comparison-button ul {
        text-align: left;
        list-style-position: inside;
        margin-bottom: 1.5rem;
    }

    .comparison-button li {
        margin-bottom: 0.5rem;
    }

    .without-btn i {
        color: var(--error);
    }

    .with-btn i {
        color: var(--secondary);
    }

    .comparison-button:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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
            padding: 0 1rem;
        }

        .search-bar input {
            width: 100%;
        }

        .search-bar button {
            width: 100%;
            padding: 1rem;
        }

        .comparison-container {
            flex-direction: column;
            align-items: center;
        }

        .comparison-button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
    <section class="hero">
        <h1>Trouvez vos médicaments en quelques clics</h1>
        <p>Localisez rapidement les pharmacies ayant vos médicaments en stock</p>
        <form action="{{ route('patient.search.index') }}" method="GET" class="search-bar" enctype="multipart/form-data">
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
        <h2>Pourquoi Nous Choisir</h2>
        <p>Découvrez comment MonMedicament transforme votre expérience de recherche de médicaments et vous fait gagner du temps et de l'énergie.</p>
        
        <div class="comparison-container">
            <div class="comparison-button without-btn">
                <h3>Sans MonMedicament</h3>
                <ul>
                    <li><i class="fas fa-times-circle"></i> Déplacements multiples et inutiles</li>
                    <li><i class="fas fa-times-circle"></i> Perte de temps considérable</li>
                    <li><i class="fas fa-times-circle"></i> Stress et frustration</li>
                    <li><i class="fas fa-times-circle"></i> Difficile pour les personnes à mobilité réduite</li>
                    <li><i class="fas fa-times-circle"></i> Coûts de transport plus élevés</li>
                </ul>
            </div>
            
            <div class="comparison-button with-btn">
                <h3>Avec MonMedicament</h3>
                <ul>
                    <li><i class="fas fa-check-circle"></i> Localisation précise et instantanée</li>
                    <li><i class="fas fa-check-circle"></i> Économie de temps et d'argent</li>
                    <li><i class="fas fa-check-circle"></i> Tranquillité d'esprit</li>
                    <li><i class="fas fa-check-circle"></i> Accessible à tous, même à distance</li>
                    <li><i class="fas fa-check-circle"></i> Optimisation de vos déplacements</li>
                </ul>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.search-bar');
        const searchInput = document.getElementById('searchInput');
        const dropArea = document.getElementById('dropArea');
        const fileUpload = document.getElementById('fileUpload');
        const cameraCapture = document.getElementById('cameraCapture');

        // Valider le formulaire de recherche
        searchForm.addEventListener('submit', function(e) {
            const hasQuery = searchInput.value.trim() !== '';
            const hasFile = fileUpload.files.length > 0 || cameraCapture.files.length > 0;
            
            if (!hasQuery && !hasFile) {
                e.preventDefault();
                alert('Veuillez entrer le nom d\'un médicament ou importer une ordonnance.');
                searchInput.focus();
            }
        });

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
    });
</script>
@endpush 