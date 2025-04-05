@extends('layouts.patient')

@section('title', 'Confirmation de la commande')

@push('styles')
<style>
    /* Progress bar */
    .progress-bar {
        background-color: var(--white);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .progress-content {
        display: flex;
        flex-direction: row;
        max-width: 1200px;
        margin: 0 auto;
        gap: 1rem;
        align-items: center;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        padding: 0.5rem 0;
        transition: transform 0.2s;
        margin-right: 2rem;
    }

    .back-button:hover {
        transform: translateX(-3px);
    }

    .steps {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .step-number {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .step.completed .step-number {
        background-color: #28a745;
        color: var(--white);
    }

    .step span {
        font-size: 1rem;
        color: var(--text-gray);
        text-align: center;
        font-weight: 500;
        white-space: nowrap;
    }

    .step.completed span {
        color: #28a745;
        font-weight: 600;
    }

    .step-line {
        height: 3px;
        width: 120px;
        background-color: #e9ecef;
        margin: 0 20px;
    }

    .step-line.completed {
        background-color: #28a745;
    }

    /* Confirmation content */
    .confirmation-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 2rem;
    }

    .confirmation-card {
        background-color: var(--white);
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #28a745;
        color: white;
        font-size: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .confirmation-card h1 {
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .confirmation-message {
        font-size: 1.1rem;
        color: var(--text-gray);
        margin-bottom: 2rem;
    }

    .order-details {
        margin: 2rem 0;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        text-align: left;
        padding: 1rem;
        background-color: #f9f9f9;
        border-radius: 0.5rem;
    }

    .detail-item i {
        font-size: 1.5rem;
        color: var(--primary);
        margin-top: 0.25rem;
    }

    .detail-label {
        display: block;
        font-size: 0.9rem;
        color: var(--text-gray);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1.1rem;
        color: var(--text-dark);
        font-weight: 600;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn-print, .btn-share {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-print {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-print:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-share {
        background-color: white;
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-share:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .info-card {
        background-color: var(--white);
        border-radius: 0.75rem;
        padding: 1.75rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .info-card h2 {
        font-size: 1.35rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        font-weight: 600;
        text-align: center;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        text-align: center;
        padding: 1.25rem;
        background-color: #f9f9f9;
        border-radius: 0.5rem;
    }

    .info-item i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .info-item p {
        font-size: 1rem;
        color: var(--text-dark);
        margin: 0;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        .progress-content {
            flex-direction: column;
        }
        .back-button {
            margin-right: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="progress-bar">
    <div class="progress-content">
        <a href="{{ route('patient.search.index') }}" class="back-button">
            <i class="fas fa-chevron-left"></i>
            <span>Retour à l'accueil</span>
        </a>
        <div class="steps">
            <div class="step completed">
                <div class="step-number">
                    <i class="fas fa-check"></i>
                </div>
                <span>Ordonnance</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step completed">
                <div class="step-number">
                    <i class="fas fa-check"></i>
                </div>
                <span>Vérification</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step completed">
                <div class="step-number">
                    <i class="fas fa-check"></i>
                </div>
                <span>Confirmation</span>
            </div>
        </div>
    </div>
</div>

<main class="confirmation-content">
    <div class="confirmation-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1>Commande confirmée !</h1>
        <p class="confirmation-message">Votre commande a été validée et sera disponible très prochainement.</p>

        <div class="order-details">
            <div class="detail-item">
                <i class="fas fa-calendar"></i>
                <div>
                    <span class="detail-label">Date de retrait</span>
                    <p class="detail-value" id="pickupDate">Aujourd'hui à 16h30</p>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <span class="detail-label">Pharmacie</span>
                    <p class="detail-value" id="pharmacyInfo">Pharmacie Centrale, 123 Avenue de la République</p>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-file-alt"></i>
                <div>
                    <span class="detail-label">Numéro de commande</span>
                    <p class="detail-value" id="orderNumber">PH-2023-1245</p>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn-print" id="printButton">
                <i class="fas fa-print"></i>
                Imprimer
            </button>
            <button class="btn-share" id="shareButton">
                <i class="fas fa-share-alt"></i>
                Partager
            </button>
        </div>
    </div>

    <div class="info-card">
        <h2>Conseils importants</h2>
        <div class="info-grid">
            <div class="info-item">
                <i class="fas fa-id-card"></i>
                <p>Présentez votre pièce d'identité</p>
            </div>
            <div class="info-item">
                <i class="fas fa-file-medical"></i>
                <p>Gardez votre ordonnance</p>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marked-alt"></i>
                <p>Vérifiez l'adresse</p>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les infos depuis localStorage
        const pharmacyName = localStorage.getItem('verificationPharmacyName') || 'Pharmacie';
        const pharmacyAddress = localStorage.getItem('verificationPharmacyAddress') || '';
        
        // Générer un numéro de commande aléatoire
        const orderNumber = 'PH-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);
        document.getElementById('orderNumber').textContent = orderNumber;
        
        // Mettre à jour les informations de pharmacie
        document.getElementById('pharmacyInfo').textContent = pharmacyName + (pharmacyAddress ? ', ' + pharmacyAddress : '');
        
        // Générer l'heure de retrait (dans 2 heures)
        const now = new Date();
        const pickupTime = new Date(now.getTime() + 2 * 60 * 60 * 1000);
        const hours = pickupTime.getHours();
        const minutes = pickupTime.getMinutes();
        const pickupTimeStr = `Aujourd'hui à ${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
        document.getElementById('pickupDate').textContent = pickupTimeStr;
        
        // Gérer le bouton d'impression
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
        
        // Gérer le bouton de partage
        document.getElementById('shareButton').addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'Ma commande de médicaments',
                    text: `J'ai commandé des médicaments à ${pharmacyName}. Numéro de commande: ${orderNumber}. Retrait: ${pickupTimeStr}.`,
                    url: window.location.href,
                })
                .catch(error => console.log('Erreur de partage:', error));
            } else {
                alert('Le partage n\'est pas pris en charge sur ce navigateur.');
            }
        });
    });
</script>
@endpush 