@extends('layouts.app')

@section('title', 'Bienvenue')

@section('header')
    <div class="text-center py-12">
        <h1 class="text-4xl font-bold text-blue-700 mb-2">
            MonMedicament
        </h1>
        <p class="text-xl text-gray-600">
            Révolutionnez votre recherche de médicaments
        </p>
    </div>
@endsection

@section('styles')
<style>
    /* Styles spécifiques pour la page d'accueil avec priorité élevée */
    /* Comment ça marche section */
    .how-it-works {
        padding: 2rem 1rem !important;
        background-color: #fff !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }

    .how-it-works h2 {
        font-size: 1.75rem !important;
        color: #333 !important;
        text-align: center !important;
        margin-bottom: 2rem !important;
    }

    .steps-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 2rem !important;
    }

    .step-card {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        padding: 1rem !important;
        position: relative !important;
    }

    .step-icon {
        background-color: #007BFF !important;
        color: #fff !important;
        width: 60px !important;
        height: 60px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-bottom: 1rem !important;
        position: relative !important;
    }

    .step-icon i {
        font-size: 1.5rem !important;
    }

    .step-number {
        position: absolute !important;
        top: -10px !important;
        right: -10px !important;
        background-color: #28A745 !important;
        color: #fff !important;
        width: 25px !important;
        height: 25px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: bold !important;
        font-size: 0.9rem !important;
    }

    .step-card h3 {
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        color: #333 !important;
        margin-bottom: 0.5rem !important;
    }

    .step-card p {
        color: #666 !important;
        font-size: 0.95rem !important;
    }

    /* Features section */
    .features-section {
        padding: 2rem 1rem !important;
        background-color: #fff !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }

    .features-section h2 {
        font-size: 1.75rem !important;
        color: #333 !important;
        text-align: center !important;
        margin-bottom: 2rem !important;
    }

    .features-grid {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }

    .feature-card {
        padding: 1.5rem !important;
        background-color: #f8f9fa !important;
        border-radius: 0.5rem !important;
        text-align: center !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        transition: transform 0.3s !important;
    }

    .feature-card:hover {
        transform: translateY(-5px) !important;
    }

    .feature-icon {
        font-size: 2.5rem !important;
        color: #007BFF !important;
        margin-bottom: 1rem !important;
    }

    .feature-card h3 {
        font-size: 1.2rem !important;
        color: #333 !important;
        margin-bottom: 0.75rem !important;
    }

    .feature-card p {
        color: #666 !important;
        font-size: 0.95rem !important;
    }

    /* Pourquoi choisir MonMedicament section */
    .why-choose-us {
        padding: 2rem 1rem !important;
        background-color: #fff !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        text-align: center !important;
    }

    .why-choose-us h2 {
        font-size: 1.75rem !important;
        color: #333 !important;
        margin-bottom: 1rem !important;
    }

    .why-choose-us > p {
        color: #666 !important;
        margin-bottom: 1.5rem !important;
        max-width: 800px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .button-container {
        display: flex !important;
        justify-content: center !important;
        margin-bottom: 1.5rem !important;
        gap: 1rem !important;
    }

    .choice-btn {
        padding: 0.5rem 1.5rem !important;
        border: 1px solid #007BFF !important;
        background-color: #fff !important;
        color: #007BFF !important;
        border-radius: 50px !important;
        cursor: pointer !important;
        transition: all 0.3s !important;
        font-weight: 500 !important;
    }

    .choice-btn.active {
        background-color: #007BFF !important;
        color: #fff !important;
    }

    .cards-container {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    #cards-with {
        display: none !important;
    }
    
    #cards-with.active {
        display: grid !important;
    }
    
    #cards-without.active {
        display: grid !important;
    }
    
    #cards-without:not(.active) {
        display: none !important;
    }

    .why-card {
        background-color: #f8f9fa !important;
        padding: 1.5rem !important;
        border-radius: 0.5rem !important;
        text-align: center !important;
    }

    .why-icon {
        width: 60px !important;
        height: 60px !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 auto 1rem !important;
    }

    .why-icon i {
        font-size: 1.5rem !important;
        color: #007BFF !important;
    }

    .why-card h3 {
        font-size: 1.2rem !important;
        color: #333 !important;
        margin-bottom: 0.5rem !important;
    }

    .why-card p {
        color: #666 !important;
        font-size: 0.95rem !important;
    }

    /* Responsive styles */
    @media (min-width: 768px) {
        .steps-container {
            flex-direction: row !important;
            justify-content: space-between !important;
        }
        
        .step-card {
            flex: 1 !important;
        }
        
        .features-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
        
        .cards-container {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    /* Témoignages */
    .testimonials {
        padding: 2rem 1rem !important;
        background-color: #fff !important;
        border-radius: 0.5rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }

    .testimonials h2 {
        font-size: 1.75rem !important;
        color: #333 !important;
        text-align: center !important;
        margin-bottom: 2rem !important;
    }

    .testimonials-container {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }

    .testimonial-card {
        padding: 1.5rem !important;
        background-color: #f8f9fa !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .testimonial-avatar {
        width: 70px !important;
        height: 70px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        margin: 0 auto 1rem !important;
    }

    .testimonial-avatar img {
        width: 100% !important;
        height: auto !important;
    }

    .quote-icon {
        color: #007BFF !important;
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
        text-align: center !important;
    }

    .testimonial-text {
        color: #555 !important;
        font-style: italic !important;
        margin-bottom: 1rem !important;
        text-align: center !important;
    }

    .testimonial-author {
        text-align: center !important;
    }

    .testimonial-author strong {
        display: block !important;
        color: #333 !important;
    }

    .author-location {
        color: #777 !important;
        font-size: 0.9rem !important;
    }

    @media (min-width: 768px) {
        .testimonials-container {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
</style>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Hero Section -->
            <div class="mb-12 text-center">
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Trouvez vos médicaments en quelques clics</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Plus de recherches interminables de pharmacie en pharmacie. Localisez instantanément les médicaments dont vous avez besoin et réservez-les en ligne.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('patient.search.pharmacy.list') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Commencer votre recherche
                    </a>
                </div>
            </div>

            <!-- Features Section -->
            <div class="features-section my-16">
                <h2>Fonctionnalités</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Recherche en temps réel</h3>
                        <p>Trouvez instantanément les pharmacies disposant des médicaments dont vous avez besoin.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Géolocalisation intelligente</h3>
                        <p>Identifiez les pharmacies les plus proches ayant vos médicaments en stock.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Réservation facile</h3>
                        <p>Réservez vos médicaments en ligne pour les récupérer sans attendre.</p>
                    </div>
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="how-it-works my-16">
                <h2>Comment ça marche ?</h2>
                
                <div class="steps-container">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                            <span class="step-number">1</span>
                        </div>
                        <h3>Recherchez vos médicaments</h3>
                        <p>Entrez le nom de votre médicament ou prenez une photo de votre ordonnance.</p>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-map-marked-alt"></i>
                            <span class="step-number">2</span>
                        </div>
                        <h3>Trouvez la pharmacie idéale</h3>
                        <p>Comparez les pharmacies selon leur distance, disponibilité et prix.</p>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-check-circle"></i>
                            <span class="step-number">3</span>
                        </div>
                        <h3>Réservez et récupérez</h3>
                        <p>Réservez en ligne et passez à la pharmacie pour récupérer vos médicaments.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action for Pharmacies -->
            <div class="why-choose-us my-16">
                <h2>Pourquoi choisir MonMedicament ?</h2>
                <p>
                    Découvrez comment MonMedicament transforme votre expérience de recherche de médicaments et vous fait gagner du temps et de l'énergie.
                </p>
                
                <div class="button-container">
                    <button class="choice-btn active" id="sans-btn">Sans MonMedicament</button>
                    <button class="choice-btn" id="avec-btn">Avec MonMedicament</button>
                </div>
                
                <div class="cards-container cards-without active" id="cards-without">
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
                
                <div class="cards-container cards-with" id="cards-with">
                    <div class="why-card">
                        <div class="why-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Recherche efficace</h3>
                        <p>Localisez vos médicaments en quelques secondes sans vous déplacer inutilement.</p>
                    </div>
                    
                    <div class="why-card">
                        <div class="why-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Gain de temps</h3>
                        <p>Économisez des heures de recherche et réservez vos médicaments en quelques clics.</p>
                    </div>
                    
                    <div class="why-card">
                        <div class="why-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <h3>Tranquillité d'esprit</h3>
                        <p>Ayez l'assurance que votre traitement est disponible avant de vous déplacer.</p>
                    </div>
                </div>
            </div>

            <!-- Testimonials Section -->
            <div class="testimonials my-16">
                <h2>Ce que nos utilisateurs disent</h2>
                
                <div class="testimonials-container">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sophie M.">
                        </div>
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">Grâce à MonMedicament, j'ai trouvé mon médicament en moins de 10 minutes. Très pratique !</p>
                        <div class="testimonial-author">
                            <strong>Sophie M.</strong>
                            <span class="author-location">Cotonou, Bénin</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David T.">
                        </div>
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">Plus besoin de faire le tour des pharmacies ! Je trouve tout ce dont j'ai besoin en quelques clics.</p>
                        <div class="testimonial-author">
                            <strong>David T.</strong>
                            <span class="author-location">Porto-Novo, Bénin</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Amina L.">
                        </div>
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">Application indispensable ! J'ai pu trouver un médicament rare pour mon fils en quelques minutes.</p>
                        <div class="testimonial-author">
                            <strong>Amina L.</strong>
                            <span class="author-location">Abomey-Calavi, Bénin</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="my-16 bg-blue-50 p-8 rounded-lg text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Vous êtes une pharmacie ?</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Rejoignez notre plateforme pour augmenter votre visibilité et attirer de nouveaux clients.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Rejoindre MonMedicament
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script chargé");
            
            const sansBtn = document.getElementById('sans-btn');
            const avecBtn = document.getElementById('avec-btn');
            const cardsWithout = document.getElementById('cards-without');
            const cardsWith = document.getElementById('cards-with');
            
            console.log("Boutons:", sansBtn, avecBtn);
            console.log("Cards containers:", cardsWithout, cardsWith);
            
            if(sansBtn && avecBtn && cardsWithout && cardsWith) {
                sansBtn.addEventListener('click', function() {
                    console.log("Clic sur Sans");
                    sansBtn.classList.add('active');
                    avecBtn.classList.remove('active');
                    cardsWithout.classList.add('active');
                    cardsWith.classList.remove('active');
                });
                
                avecBtn.addEventListener('click', function() {
                    console.log("Clic sur Avec");
                    avecBtn.classList.add('active');
                    sansBtn.classList.remove('active');
                    cardsWith.classList.add('active');
                    cardsWithout.classList.remove('active');
                });
            }
        });
    </script>
@endsection
