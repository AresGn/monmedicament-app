@extends('layouts.patient')

@section('title', 'Conditions d\'utilisation')

@push('styles')
<style>
    .terms-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .terms-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .terms-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .terms-content {
        color: #333;
    }

    .terms-content h2 {
        color: var(--primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .terms-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .terms-content ul {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .terms-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="terms-container">
    <div class="terms-header">
        <h1>Conditions d'utilisation</h1>
    </div>

    <div class="terms-content">
        <p>Bienvenue sur MonMedicament. En utilisant notre plateforme, vous acceptez de respecter les conditions suivantes :</p>

        <h2>1. Acceptation des conditions</h2>
        <p>En accédant à ce site, vous acceptez d'être lié par ces conditions d'utilisation, toutes les lois et règlements applicables, et vous acceptez que vous êtes responsable du respect des lois locales applicables.</p>

        <h2>2. Utilisation de la plateforme</h2>
        <p>MonMedicament est une plateforme permettant aux utilisateurs de rechercher des médicaments disponibles dans les pharmacies à proximité. Vous vous engagez à utiliser cette plateforme uniquement à des fins légales et conformément à ces conditions.</p>

        <h2>3. Création de compte</h2>
        <p>Pour utiliser certaines fonctionnalités de notre plateforme, vous devrez créer un compte. Vous êtes responsable de maintenir la confidentialité de votre compte et mot de passe et de restreindre l'accès à votre ordinateur. Vous acceptez d'assumer la responsabilité de toutes les activités qui se produisent sous votre compte.</p>

        <h2>4. Exactitude des informations</h2>
        <p>MonMedicament s'efforce de fournir des informations précises sur la disponibilité des médicaments dans les pharmacies partenaires. Cependant, nous ne pouvons garantir l'exactitude absolue de ces informations en temps réel. Nous vous recommandons de contacter directement la pharmacie pour confirmer la disponibilité avant de vous déplacer.</p>

        <h2>5. Confidentialité</h2>
        <p>Votre utilisation du site est également régie par notre Politique de Confidentialité, qui est incorporée dans ces conditions par référence.</p>

        <h2>6. Modifications</h2>
        <p>MonMedicament se réserve le droit de modifier ces conditions à tout moment. Nous vous informerons des modifications importantes apportées à ces conditions.</p>

        <h2>7. Contact</h2>
        <p>Si vous avez des questions concernant ces conditions d'utilisation, veuillez nous contacter à l'adresse suivante : support@monmedicament.com</p>
    </div>
</div>
@endsection 