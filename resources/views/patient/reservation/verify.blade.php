@extends('layouts.patient')

@section('title', 'Vérification de la commande')

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

    .step.active .step-number {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.15);
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

    .step.active span {
        color: var(--primary);
        font-weight: 600;
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

    /* Verification content */
    .verification-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 2rem;
    }

    .main-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 992px) {
        .main-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    .verification-section, .additional-info, .pharmacy-info, .order-summary, .important-note {
        background-color: var(--white);
        border-radius: 0.75rem;
        padding: 1.75rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }

    h2 {
        font-size: 1.35rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
    }

    .success-message {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background-color: rgba(40, 167, 69, 0.1);
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .success-message i {
        font-size: 2rem;
        color: #28a745;
    }

    .success-message h3 {
        font-size: 1.1rem;
        color: #28a745;
        margin-bottom: 0.25rem;
    }

    .success-message p {
        font-size: 0.9rem;
        color: var(--text-gray);
        margin: 0;
    }

    .medicines-list {
        margin-bottom: 1.5rem;
    }

    .medicine-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .medicine-item:last-child {
        border-bottom: none;
    }

    .quantity {
        font-weight: 600;
        color: var(--primary);
    }

    textarea {
        width: 100%;
        padding: 0.9rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        background-color: var(--light-gray);
        font-family: 'Roboto', sans-serif;
        min-height: 100px;
        resize: vertical;
    }

    .pharmacy-card {
        display: flex;
        gap: 1.25rem;
        align-items: center;
    }

    .pharmacy-image {
        width: 70px;
        height: 70px;
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: #e9ecef;
        background-image: url("{{ asset('img/pharmacy-placeholder.jpg') }}");
        background-size: cover;
        background-position: center;
    }

    .pharmacy-details h3 {
        font-size: 1.1rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .pharmacy-details p {
        font-size: 0.9rem;
        color: var(--text-gray);
        margin: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .summary-details {
        margin-top: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
    }

    .summary-row.total {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-dark);
        border-bottom: none;
    }

    .important-note {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background-color: rgba(255, 193, 7, 0.1);
        border-radius: 0.5rem;
    }

    .important-note i {
        font-size: 1.5rem;
        color: #ffc107;
    }

    .important-note h3 {
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .important-note p {
        font-size: 0.9rem;
        color: var(--text-gray);
        margin: 0;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .btn-confirm, .btn-modify {
        display: inline-block;
        padding: 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }

    .btn-confirm {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-confirm:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-modify {
        background-color: var(--white);
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-modify:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    @media (max-width: 768px) {
        .progress-content {
            flex-direction: column;
            gap: 1.5rem;
        }

        .back-button {
            margin-right: 0;
        }
    }

    /* Styles pour le modal de paiement */
    .payment-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .payment-modal.active {
        display: flex;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.25rem;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .info-message {
        display: flex;
        gap: 0.75rem;
        background-color: rgba(13, 110, 253, 0.1);
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    .info-message i {
        color: #0d6efd;
        font-size: 1.25rem;
        margin-top: 0.1rem;
    }

    .info-message p {
        margin: 0;
        font-size: 0.9rem;
        color: #495057;
    }

    .payment-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group input[readonly] {
        background-color: #f8f9fa;
    }

    .btn-confirm-payment {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background-color: #0ea5e9;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.2s;
    }

    .btn-confirm-payment:hover {
        background-color: #0284c7;
    }
</style>
@endpush

@section('content')
<div class="progress-bar">
    <div class="progress-content">
        <a href="javascript:history.back()" class="back-button">
            <i class="fas fa-chevron-left"></i>
            <span>Retour</span>
        </a>
        <div class="steps">
            <div class="step completed">
                <div class="step-number">
                    <i class="fas fa-check"></i>
                </div>
                <span>Ordonnance</span>
            </div>
            <div class="step-line completed"></div>
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

<main class="verification-content">
    <div class="main-grid">
        <!-- Colonne principale (gauche) -->
        <div class="main-column">
            <section class="verification-section">
                <h2>Vérification de l'ordonnance</h2>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h3>Ordonnance validée</h3>
                        <p>Votre ordonnance a été vérifiée et correspond aux médicaments disponibles.</p>
                    </div>
                </div>
                <div class="medicines-list" id="medicinesList">
                    <!-- Medicines will be populated dynamically via JavaScript -->
                </div>
            </section>

            <section class="additional-info">
                <h2>Instructions supplémentaires</h2>
                <textarea placeholder="Instructions supplémentaires pour le pharmacien..."></textarea>
            </section>
        </div>

        <!-- Colonne latérale (droite) -->
        <div class="side-column">
            <section class="pharmacy-info">
                <h2>Pharmacie sélectionnée</h2>
                <div class="pharmacy-card">
                    <div class="pharmacy-image"></div>
                    <div class="pharmacy-details" id="pharmacyDetails">
                        <!-- Pharmacy details will be populated dynamically via JavaScript -->
                    </div>
                </div>
            </section>

            <section class="order-summary">
                <h2>Récapitulatif de la commande</h2>
                <div class="summary-details">
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span>42.50 €</span>
                    </div>
                    <div class="summary-row">
                        <span>Frais de service</span>
                        <span>2.50 €</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>45.00 €</span>
                    </div>
                </div>
            </section>

            <div class="important-note">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <h3>Note importante</h3>
                    <p>L'ordonnance originale devra être présentée lors du retrait.</p>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn-confirm" id="confirmOrder">Confirmer la commande</button>
                <button class="btn-modify" onclick="javascript:history.back()">Modifier la commande</button>
            </div>
        </div>
    </div>
</main>

<!-- Modal de réservation -->
<div id="paymentModal" class="payment-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Réservation de votre commande</h2>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                <p>Nous exigeons une réservation pour être sûr que vous allez passer récupérer votre commande pour ne pas que quelqu'un d'autre vienne payer le stock restant.</p>
            </div>

            <form id="paymentForm" class="payment-form">
                <div class="form-group">
                    <label for="operator">Opérateur Mobile Money</label>
                    <select id="operator" required>
                        <option value="">Sélectionnez un opérateur</option>
                        <option value="mtn">MTN</option>
                        <option value="moov">MOOV</option>
                        <option value="celtiis">CELTIIS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Numéro de téléphone</label>
                    <input type="tel" id="phoneNumber" required pattern="[0-9]{8}" placeholder="Ex: 97000000">
                </div>

                <div class="form-group">
                    <label for="fullName">Nom complet</label>
                    <input type="text" id="fullName" required placeholder="Entrez votre nom complet">
                </div>

                <div class="form-group">
                    <label>Montant de la réservation (30%)</label>
                    <input type="text" id="reservationAmount" readonly>
                </div>

                <button type="submit" class="btn-confirm-payment">
                    <i class="fas fa-lock"></i>
                    Confirmer ma réservation
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get stored values from localStorage
        const pharmacyId = localStorage.getItem('verificationPharmacyId');
        const pharmacyName = localStorage.getItem('verificationPharmacyName');
        const pharmacyAddress = localStorage.getItem('verificationPharmacyAddress');
        const medicinesJson = localStorage.getItem('verificationMedicines');
        const searchQuery = localStorage.getItem('lastMedicineSearch');
        
        // Modal de paiement
        const paymentModal = document.getElementById('paymentModal');
        const confirmOrderBtn = document.getElementById('confirmOrder');
        const closeModalBtn = document.querySelector('.close-modal');
        const paymentForm = document.getElementById('paymentForm');
        let orderTotal = 0;
        
        // Ouvrir modal au clic sur Confirmer
        if (confirmOrderBtn) {
            confirmOrderBtn.addEventListener('click', function() {
                // Calculer 30% du total comme montant de réservation
                const reservationAmount = (orderTotal / 100 * 0.3).toFixed(2);
                document.getElementById('reservationAmount').value = reservationAmount + ' €';
                
                // Afficher le modal
                paymentModal.classList.add('active');
            });
        }
        
        // Fermer modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function() {
                paymentModal.classList.remove('active');
            });
        }
        
        // Clic en dehors du modal pour fermer
        window.addEventListener('click', function(event) {
            if (event.target === paymentModal) {
                paymentModal.classList.remove('active');
            }
        });
        
        // Traiter le formulaire de paiement
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simuler le traitement du paiement
                const operator = document.getElementById('operator').value;
                const phoneNumber = document.getElementById('phoneNumber').value;
                const fullName = document.getElementById('fullName').value;
                
                if (!operator || !phoneNumber || !fullName) {
                    alert('Veuillez remplir tous les champs');
                    return;
                }
                
                // Cacher le modal
                paymentModal.classList.remove('active');
                
                // Stocker les informations de paiement dans localStorage (optionnel)
                localStorage.setItem('paymentOperator', operator);
                localStorage.setItem('paymentPhone', phoneNumber);
                localStorage.setItem('paymentName', fullName);
                
                // Rediriger vers la page de confirmation
                window.location.href = "{{ route('patient.reservations.confirm') }}";
            });
        }
        
        // Update pharmacy details
        const pharmacyDetails = document.getElementById('pharmacyDetails');
        if (pharmacyDetails && pharmacyName) {
            pharmacyDetails.innerHTML = `
                <h3>${pharmacyName || 'Pharmacie'}</h3>
                <p><i class="fas fa-map-marker-alt"></i> ${pharmacyAddress || 'Adresse non disponible'}</p>
                <p><i class="fas fa-clock"></i> Ouvert aujourd'hui</p>
            `;
        }
        
        // Populate medicines list from localStorage
        const medicinesList = document.getElementById('medicinesList');
        if (medicinesList) {
            // First try to use medicines from localStorage
            if (medicinesJson) {
                try {
                    const medicines = JSON.parse(medicinesJson);
                    if (medicines && medicines.length > 0) {
                        let medicinesHtml = '';
                        let total = 0;
                        
                        medicines.forEach(medicine => {
                            const price = medicine.price || 1500;
                            const quantity = medicine.quantity || 1;
                            const itemTotal = price * quantity;
                            total += itemTotal;
                            
                            medicinesHtml += `
                                <div class="medicine-item">
                                    <span>${medicine.name}</span>
                                    <span class="quantity">${quantity} boîte${quantity > 1 ? 's' : ''}</span>
                                </div>
                            `;
                        });
                        
                        medicinesList.innerHTML = medicinesHtml;
                        
                        // Update the total in the order summary
                        updateOrderSummary(total);
                        return;
                    }
                } catch (e) {
                    console.error('Error parsing medicines JSON:', e);
                }
            }
            
            // Fallback to search query if no medicines in localStorage
            if (searchQuery) {
                const medicines = searchQuery.split(',').map(med => med.trim()).filter(med => med);
                
                if (medicines.length > 0) {
                    let medicinesHtml = '';
                    let total = 0;
                    
                    medicines.forEach((medicine, index) => {
                        // Generate random price and quantity for demo purposes
                        const price = 1500 + (index * 500);
                        const quantity = Math.floor(Math.random() * 2) + 1;
                        total += price * quantity;
                        
                        medicinesHtml += `
                            <div class="medicine-item">
                                <span>${medicine}</span>
                                <span class="quantity">${quantity} boîte${quantity > 1 ? 's' : ''}</span>
                            </div>
                        `;
                    });
                    
                    medicinesList.innerHTML = medicinesHtml;
                    
                    // Update the order summary
                    updateOrderSummary(total);
                    return;
                }
            }
            
            // Default medicines if nothing else is available
            medicinesList.innerHTML = `
                <div class="medicine-item">
                    <span>Paracétamol 1000mg</span>
                    <span class="quantity">2 boîtes</span>
                </div>
                <div class="medicine-item">
                    <span>Amoxicilline 500mg</span>
                    <span class="quantity">1 boîte</span>
                </div>
                <div class="medicine-item">
                    <span>Ibuprofène 200mg</span>
                    <span class="quantity">1 boîte</span>
                </div>
            `;
            
            // Default total
            updateOrderSummary(4250);
        }
        
        // Update order summary with calculated total
        function updateOrderSummary(total) {
            const serviceFee = 250;
            orderTotal = total + serviceFee;
            
            const summaryDetails = document.querySelector('.summary-details');
            if (summaryDetails) {
                summaryDetails.innerHTML = `
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span>${(total/100).toFixed(2)} €</span>
                    </div>
                    <div class="summary-row">
                        <span>Frais de service</span>
                        <span>${(serviceFee/100).toFixed(2)} €</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${(orderTotal/100).toFixed(2)} €</span>
                    </div>
                `;
            }
        }
    });
</script>
@endpush 