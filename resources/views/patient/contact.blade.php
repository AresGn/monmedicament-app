@extends('layouts.patient')

@section('title', 'Contact')

@push('styles')
<style>
    .contact-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .contact-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .contact-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .contact-method {
        flex: 1;
        min-width: 200px;
        background-color: var(--neutral);
        padding: 1.5rem;
        border-radius: 0.5rem;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .contact-method:hover {
        transform: translateY(-5px);
    }

    .contact-method i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .contact-method h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .contact-method p {
        color: #666;
    }

    .contact-form {
        margin-top: 3rem;
    }

    .form-title {
        color: var(--primary);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .btn-submit {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        display: block;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    .btn-submit:hover {
        background-color: #0b7a6d;
    }

    .contact-map {
        margin-top: 3rem;
        height: 300px;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .contact-container {
            padding: 1.5rem;
            margin: 2rem auto;
        }

        .contact-info {
            flex-direction: column;
        }

        .contact-method {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="contact-container">
    <div class="contact-header">
        <h1>Contactez-nous</h1>
        <p>Nous sommes là pour vous aider. N'hésitez pas à nous contacter si vous avez des questions ou des commentaires.</p>
    </div>

    <div class="contact-info">
        <div class="contact-method">
            <i class="fas fa-envelope"></i>
            <h3>Email</h3>
            <p>support@monmedicament.com</p>
        </div>

        <div class="contact-method">
            <i class="fas fa-phone-alt"></i>
            <h3>Téléphone</h3>
            <p>+229 97 15 68 42</p>
        </div>

        <div class="contact-method">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Adresse</h3>
            <p>123 Rue des Pharmaciens<br>Cotonou, Bénin</p>
        </div>
    </div>

    <div class="contact-form">
        <h2 class="form-title">Envoyez-nous un message</h2>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="subject">Sujet</label>
                <input type="text" id="subject" name="subject" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </form>
    </div>

    <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126931.66373132428!2d2.2881489453124956!3d6.367333999999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023550eec4cd72d%3A0x4b320fcf01491faa!2sCotonou%2C%20Benin!5e0!3m2!1sen!2sus!4v1648830292211!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
@endsection 