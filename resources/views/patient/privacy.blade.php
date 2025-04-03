@extends('layouts.patient')

@section('title', 'Politique de confidentialité')

@push('styles')
<style>
    .privacy-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .privacy-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .privacy-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .privacy-content {
        color: #333;
    }

    .privacy-content h2 {
        color: var(--primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .privacy-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .privacy-content ul {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .privacy-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="privacy-container">
    <div class="privacy-header">
        <h1>Politique de confidentialité</h1>
    </div>

    <div class="privacy-content">
        <p>Cette politique de confidentialité décrit comment MonMedicament collecte, utilise et protège vos informations personnelles lorsque vous utilisez notre plateforme.</p>

        <h2>1. Informations que nous collectons</h2>
        <p>Nous collectons les informations suivantes :</p>
        <ul>
            <li>Informations d'identification (nom, adresse e-mail, numéro de téléphone)</li>
            <li>Informations de localisation (pour trouver les pharmacies à proximité)</li>
            <li>Recherches de médicaments et historique d'utilisation</li>
            <li>Informations sur votre appareil et votre navigateur</li>
        </ul>

        <h2>2. Comment nous utilisons vos informations</h2>
        <p>Nous utilisons vos informations pour :</p>
        <ul>
            <li>Vous fournir nos services de recherche de médicaments</li>
            <li>Améliorer notre plateforme et nos services</li>
            <li>Communiquer avec vous concernant votre compte</li>
            <li>Vous envoyer des informations sur nos services (si vous y avez consenti)</li>
        </ul>

        <h2>3. Protection de vos données</h2>
        <p>Nous prenons la protection de vos données personnelles très au sérieux. Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos informations contre la perte, l'utilisation abusive et l'accès non autorisé.</p>

        <h2>4. Partage de vos informations</h2>
        <p>Nous ne vendons pas vos informations personnelles à des tiers. Nous pouvons partager vos informations avec :</p>
        <ul>
            <li>Les pharmacies partenaires (uniquement pour faciliter vos réservations)</li>
            <li>Nos prestataires de services (qui nous aident à exploiter notre plateforme)</li>
            <li>Les autorités légales (si la loi nous y oblige)</li>
        </ul>

        <h2>5. Vos droits</h2>
        <p>Vous avez le droit de :</p>
        <ul>
            <li>Accéder à vos données personnelles</li>
            <li>Rectifier vos données</li>
            <li>Supprimer vos données</li>
            <li>Limiter le traitement de vos données</li>
            <li>Vous opposer au traitement de vos données</li>
            <li>Retirer votre consentement à tout moment</li>
        </ul>

        <h2>6. Modifications</h2>
        <p>Nous pouvons modifier cette politique de confidentialité à tout moment. Les modifications prendront effet dès leur publication sur notre plateforme.</p>

        <h2>7. Contact</h2>
        <p>Pour toute question concernant cette politique de confidentialité, veuillez nous contacter à l'adresse suivante : privacy@monmedicament.com</p>
    </div>
</div>
@endsection 