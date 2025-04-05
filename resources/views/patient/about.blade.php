@extends('layouts.patient')

@section('title', 'À propos')

@push('styles')
<style>
    .about-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .about-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .about-header h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .about-header p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .about-section {
        margin-bottom: 4rem;
    }

    .about-section h2 {
        color: var(--primary);
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .about-section h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--primary);
    }

    .about-section p {
        color: #444;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .mission-vision {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin-top: 2rem;
    }

    .mission-card, .vision-card {
        flex: 1;
        min-width: 250px;
        background-color: var(--neutral);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .mission-card h3, .vision-card h3 {
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
    }

    .mission-card h3 i, .vision-card h3 i {
        margin-right: 0.5rem;
    }

    .values-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .value-item {
        background-color: var(--neutral);
        padding: 1.5rem;
        border-radius: 1rem;
        text-align: center;
        transition: transform 0.3s;
    }

    .value-item:hover {
        transform: translateY(-5px);
    }

    .value-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .value-name {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .value-desc {
        font-size: 0.9rem;
        color: #666;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .team-member {
        text-align: center;
    }

    .team-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-name {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .team-role {
        color: var(--primary);
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .team-bio {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
    }

    .timeline {
        position: relative;
        max-width: 600px;
        margin: 2rem auto;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--primary);
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline-item {
        padding: 1rem 0;
        position: relative;
    }

    .timeline-content {
        width: 45%;
        padding: 1.5rem;
        background: var(--neutral);
        border-radius: 0.5rem;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.05);
    }

    .timeline-item:nth-child(odd) .timeline-content {
        float: right;
    }

    .timeline-item:nth-child(even) .timeline-content {
        float: left;
    }

    .timeline-year {
        position: absolute;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        z-index: 1;
    }

    .timeline-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .timeline-desc {
        font-size: 0.9rem;
        color: #666;
    }

    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    @media (max-width: 768px) {
        .about-container {
            padding: 1.5rem;
            margin: 2rem auto;
        }

        .timeline:before {
            left: 30px;
        }

        .timeline-content {
            width: calc(100% - 80px);
            float: right;
        }

        .timeline-item:nth-child(odd) .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            float: right;
        }

        .timeline-year {
            left: 30px;
            transform: translate(-50%, -50%);
        }
    }
</style>
@endpush

@section('content')
<div class="about-container">
    <div class="about-header">
        <h1>À propos de MonMedicament</h1>
        <p>Découvrez notre histoire, notre mission et les personnes qui rendent possible la recherche facile de médicaments au Bénin.</p>
    </div>

    <div class="about-section">
        <h2>Notre histoire</h2>
        <p>Fondée en 2023 à Cotonou, MonMedicament est née d'une frustration commune : la difficulté à trouver rapidement des médicaments en cas d'urgence. Notre fondateur, après avoir perdu des heures à parcourir plusieurs pharmacies pour trouver un médicament urgent pour un membre de sa famille, a décidé que cette situation devait changer.</p>
        
        <p>Aujourd'hui, MonMedicament est devenue la première plateforme béninoise permettant aux patients de localiser facilement les pharmacies disposant des médicaments dont ils ont besoin, leur évitant ainsi des déplacements inutiles et parfois dangereux en cas d'urgence médicale.</p>

        <div class="timeline">
            <div class="timeline-item clearfix">
                <div class="timeline-year">2023</div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Naissance de l'idée</h3>
                    <p class="timeline-desc">Conceptualisation de la plateforme suite à une expérience personnelle difficile.</p>
                </div>
            </div>
            
            <div class="timeline-item clearfix">
                <div class="timeline-year">2023</div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Premiers partenariats</h3>
                    <p class="timeline-desc">Signature avec les premières pharmacies partenaires à Cotonou.</p>
                </div>
            </div>
            
            <div class="timeline-item clearfix">
                <div class="timeline-year">2024</div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Lancement officiel</h3>
                    <p class="timeline-desc">Déploiement de la plateforme MonMedicament au Bénin.</p>
                </div>
            </div>
            
            <div class="timeline-item clearfix">
                <div class="timeline-year">2024</div>
                <div class="timeline-content">
                    <h3 class="timeline-title">Expansion nationale</h3>
                    <p class="timeline-desc">Extension du réseau à toutes les grandes villes du Bénin.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="about-section">
        <h2>Notre mission et vision</h2>
        
        <div class="mission-vision">
            <div class="mission-card">
                <h3><i class="fas fa-bullseye"></i> Notre mission</h3>
                <p>Faciliter l'accès aux médicaments pour tous les Béninois en connectant les patients avec les pharmacies disposant des médicaments dont ils ont besoin, n'importe où, n'importe quand.</p>
            </div>
            
            <div class="vision-card">
                <h3><i class="fas fa-eye"></i> Notre vision</h3>
                <p>Créer un écosystème de santé connecté où personne ne devrait être privé de médicaments par manque d'information sur leur disponibilité.</p>
            </div>
        </div>
    </div>

    <div class="about-section">
        <h2>Nos valeurs</h2>
        <p>Chez MonMedicament, nos actions sont guidées par un ensemble de valeurs fondamentales qui définissent notre culture et nos relations avec nos utilisateurs et partenaires.</p>
        
        <div class="values-list">
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="value-name">Compassion</div>
                <div class="value-desc">Nous plaçons le bien-être des patients au cœur de toutes nos décisions.</div>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="value-name">Confiance</div>
                <div class="value-desc">Nous nous engageons à fournir des informations fiables et à protéger la confidentialité des utilisateurs.</div>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="value-name">Innovation</div>
                <div class="value-desc">Nous cherchons constamment à améliorer notre service pour mieux répondre aux besoins des patients.</div>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <div class="value-name">Accessibilité</div>
                <div class="value-desc">Nous travaillons à rendre les soins de santé accessibles à tous, quel que soit leur lieu de résidence.</div>
            </div>
        </div>
    </div>

    <div class="about-section">
        <h2>Notre équipe</h2>
        <p>MonMedicament est le fruit du travail acharné d'une équipe passionnée, déterminée à améliorer l'accès aux médicaments au Bénin.</p>
        
        <div class="team-grid">
            <div class="team-member">
                <div class="team-avatar">
                    <img src="https://randomuser.me/api/portraits/men/40.jpg" alt="Jean Koffi">
                </div>
                <h3 class="team-name">Jean Koffi</h3>
                <div class="team-role">Fondateur & CEO</div>
                <p class="team-bio">Pharmacien de formation, Jean a fondé MonMedicament après avoir constaté les difficultés rencontrées par les patients pour trouver leurs médicaments.</p>
            </div>
            
            <div class="team-member">
                <div class="team-avatar">
                    <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Marie Sossou">
                </div>
                <h3 class="team-name">Marie Sossou</h3>
                <div class="team-role">Directrice des Opérations</div>
                <p class="team-bio">Avec plus de 10 ans d'expérience dans le secteur pharmaceutique, Marie assure la liaison avec notre réseau de pharmacies partenaires.</p>
            </div>
            
            <div class="team-member">
                <div class="team-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Paul Agbogba">
                </div>
                <h3 class="team-name">Paul Agbogba</h3>
                <div class="team-role">Directeur Technique</div>
                <p class="team-bio">Ingénieur en développement logiciel, Paul est le cerveau derrière notre plateforme technologique innovante.</p>
            </div>
            
            <div class="team-member">
                <div class="team-avatar">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophie Adandé">
                </div>
                <h3 class="team-name">Sophie Adandé</h3>
                <div class="team-role">Responsable Marketing</div>
                <p class="team-bio">Sophie apporte sa créativité et son expertise en communication pour faire connaître MonMedicament à travers le Bénin.</p>
            </div>
        </div>
    </div>
</div>
@endsection 