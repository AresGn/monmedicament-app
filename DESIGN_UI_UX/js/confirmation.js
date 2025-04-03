document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les données de confirmation depuis localStorage
    const confirmationData = JSON.parse(localStorage.getItem('confirmationData') || '{}');
    
    // Mettre à jour les détails de la commande si disponibles
    if (confirmationData.confirmationId) {
        updateOrderDetails(confirmationData);
    }

    // Gestionnaire pour le bouton d'impression
    const printButton = document.querySelector('.btn-print');
    if (printButton) {
        printButton.addEventListener('click', handlePrint);
    }

    // Gestionnaire pour le bouton de partage
    const shareButton = document.querySelector('.btn-share');
    if (shareButton) {
        shareButton.addEventListener('click', handleShare);
    }
});

function updateOrderDetails(data) {
    // Mettre à jour la date de retrait
    const pickupDate = document.querySelector('.detail-value');
    if (pickupDate && data.pickupDate) {
        pickupDate.textContent = formatDate(data.pickupDate);
    }

    // Mettre à jour le numéro de commande
    const orderNumber = document.querySelectorAll('.detail-value')[2];
    if (orderNumber && data.confirmationId) {
        orderNumber.textContent = data.confirmationId;
    }

    // Mettre à jour les informations de la pharmacie
    const pharmacyInfo = document.querySelectorAll('.detail-value')[1];
    if (pharmacyInfo && data.pharmacyName) {
        pharmacyInfo.textContent = `${data.pharmacyName}, ${data.pharmacyAddress || ''}`;
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const today = new Date();
    
    if (date.toDateString() === today.toDateString()) {
        return `Aujourd'hui à ${date.getHours().toString().padStart(2, '0')}h${date.getMinutes().toString().padStart(2, '0')}`;
    }
    
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(date);
}

function handlePrint() {
    window.print();
}

function handleShare() {
    // Vérifier si l'API de partage est disponible
    if (navigator.share) {
        const confirmationData = JSON.parse(localStorage.getItem('confirmationData') || '{}');
        
        navigator.share({
            title: 'Ma commande PharmLocator',
            text: `Commande ${confirmationData.confirmationId} confirmée chez ${confirmationData.pharmacyName}`,
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback si l'API de partage n'est pas disponible
        const tempInput = document.createElement('input');
        tempInput.value = window.location.href;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert('Lien copié dans le presse-papier !');
    }
}