document.addEventListener('DOMContentLoaded', function() {
    const confirmButton = document.querySelector('.btn-confirm');
    const modifyButton = document.querySelector('.btn-modify');
    const modal = document.getElementById('paymentModal');
    const closeModal = document.querySelector('.close-modal');
    const paymentForm = document.getElementById('paymentForm');
    const totalAmount = 45.00; // Le montant total de la commande
    const reservationPercentage = 0.3; // 30%

    // Calculer et afficher le montant de la réservation
    const reservationAmount = document.getElementById('reservationAmount');
    reservationAmount.value = `${(totalAmount * reservationPercentage).toFixed(2)} €`;

    // Ouvrir le modal lors du clic sur "Confirmer la commande"
    confirmButton.addEventListener('click', () => {
        modal.classList.add('active');
    });

    // Fermer le modal
    closeModal.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Gestion du formulaire de paiement
    paymentForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const paymentData = {
            operator: document.getElementById('operator').value,
            phoneNumber: document.getElementById('phoneNumber').value,
            fullName: document.getElementById('fullName').value,
            amount: (totalAmount * reservationPercentage).toFixed(2)
        };

        try {
            const submitButton = e.target.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';

            // Simuler un délai de traitement
            await new Promise(resolve => setTimeout(resolve, 1500));

            // Sauvegarder les données dans localStorage
            const confirmationData = {
                pharmacyName: "Pharmacie Centrale",
                confirmationId: "PH-" + Math.random().toString(36).substr(2, 9).toUpperCase(),
                pickupDate: new Date().toISOString(),
                amount: paymentData.amount,
                paymentInfo: paymentData
            };

            localStorage.setItem('confirmationData', JSON.stringify(confirmationData));

            // Rediriger vers la page de confirmation
            window.location.href = 'confirmation.html';

        } catch (error) {
            alert('Une erreur est survenue. Veuillez réessayer.');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-lock"></i> Confirmer ma réservation';
        }
    });
});
