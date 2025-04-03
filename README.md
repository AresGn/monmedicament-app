# MonMédicament - Application de recherche de médicaments en pharmacie

## Structure du projet

Le projet est structuré de manière à permettre à deux développeurs de travailler simultanément sur des interfaces distinctes :
- Interface Patient : Pour la recherche de médicaments et la gestion des réservations par les patients
- Interface Pharmacie : Pour la gestion des inventaires et réservations par les pharmacies

### Organisation des dossiers

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Patient/           # Contrôleurs pour l'interface patient
│   │   └── Pharmacy/          # Contrôleurs pour l'interface pharmacie
│   └── Middleware/            # Middleware d'authentification pour patients et pharmacies
├── Models/                    # Modèles partagés
└── ...

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php      # Layout principal de l'application
│   │   ├── patient.blade.php  # Layout spécifique à l'interface patient
│   │   └── pharmacy.blade.php # Layout spécifique à l'interface pharmacie
│   ├── patient/               # Vues pour l'interface patient
│   └── pharmacy/              # Vues pour l'interface pharmacie
└── ...

routes/
├── web.php                   # Routes principales
├── patient.php               # Routes spécifiques à l'interface patient
└── pharmacy.php              # Routes spécifiques à l'interface pharmacie
```

## Instructions pour les développeurs

### Développeur 1 : Interface Patient

Vous travaillerez sur les fichiers suivants :
- `app/Http/Controllers/Patient/*`
- `resources/views/patient/*`
- `routes/patient.php`

Pour créer une nouvelle page dans l'interface patient, suivez ces étapes :
1. Créez un contrôleur dans `app/Http/Controllers/Patient/`
2. Ajoutez les routes dans `routes/patient.php`
3. Créez la vue dans `resources/views/patient/`
4. Utilisez le layout `@extends('layouts.patient')` pour vos vues

### Développeur 2 : Interface Pharmacie

Vous travaillerez sur les fichiers suivants :
- `app/Http/Controllers/Pharmacy/*`
- `resources/views/pharmacy/*`
- `routes/pharmacy.php`

Pour créer une nouvelle page dans l'interface pharmacie, suivez ces étapes :
1. Créez un contrôleur dans `app/Http/Controllers/Pharmacy/`
2. Ajoutez les routes dans `routes/pharmacy.php`
3. Créez la vue dans `resources/views/pharmacy/`
4. Utilisez le layout `@extends('layouts.pharmacy')` pour vos vues

## Modèles partagés

Les modèles sont partagés entre les deux interfaces et se trouvent dans `app/Models/`. Si vous devez modifier un modèle, assurez-vous de communiquer avec l'autre développeur pour éviter les conflits.

## Installation et configuration

1. Clonez le dépôt
2. Exécutez `composer install`
3. Copiez `.env.example` vers `.env` et configurez votre base de données
4. Exécutez `php artisan key:generate`
5. Exécutez `php artisan migrate`
6. Exécutez `php artisan db:seed` (si nécessaire)
7. Exécutez `npm install && npm run dev`

## Conventions de codage

- Respectez les conventions de codage de Laravel
- Utilisez le français pour les noms de vues, routes et commentaires
- Utilisez la notation camelCase pour les variables et méthodes
- Utilisez la notation PascalCase pour les classes et modèles

## Démarrage de l'application

Pour démarrer l'application en local, exécutez :
```
php artisan serve
```

L'application sera disponible à l'adresse http://localhost:8000

# MonMedicament

## Révolutionnez votre recherche de médicaments

### Contexte et Problématique

En Afrique, où les infrastructures de santé sont souvent sous pression, l'accès rapide et efficace aux médicaments demeure un défi majeur pour des millions de patients. Actuellement, la recherche de médicaments peut être un processus long, coûteux et frustrant :
- **Chronophage** : Les patients doivent souvent visiter plusieurs pharmacies avant de trouver leurs médicaments.
- **Stressante** : Une situation d'urgence aggrave la pression pour obtenir les traitements à temps.
- **Inefficace** : De nombreux déplacements inutiles, surtout dans des zones urbaines encombrées.
- **Contraignante** : Les personnes à mobilité réduite ou vivant dans des régions isolées sont particulièrement touchées.

### Notre Vision : Une Santé Accessible à Tous

MonMedicament a pour mission de révolutionner la recherche de médicaments en Afrique. Nous voulons créer un écosystème où chaque patient peut accéder à ses traitements rapidement, efficacement et sans stress.

### MonMedicament : Une Solution Innovante

MonMedicament est une plateforme numérique intuitive qui connecte les patients et les pharmacies à travers une technologie de pointe.

#### Fonctionnement de la Plateforme

1. **Pour les Patients**
   - **Scanner ou saisir une ordonnance** : Les utilisateurs peuvent simplement prendre une photo de leur ordonnance ou entrer les noms des médicaments.
   - **Rechercher en temps réel** : La plateforme localise instantanément les pharmacies disposant des médicaments recherchés.
   - **Choisir la pharmacie idéale** : Les patients peuvent comparer les distances, disponibilités et prix pour faire le meilleur choix.

2. **Pour les Pharmacies**
   - **Interface de gestion simple** : Les pharmacies mettent à jour leurs stocks en temps réel.
   - **Visibilité accrue** : Elles apparaissent sur la carte des patients recherchant des médicaments.
   - **Optimisation des ventes** : La plateforme aide à écouler les stocks et à attirer une nouvelle clientèle.

### Avantages Clés

#### Pour les Patients
- **Temps gagné** : Accès rapide aux médicaments, surtout en situation d'urgence.
- **Confort et simplicité** : Une recherche digitale depuis chez soi ou en déplacement.
- **Précision** : Informations fiables sur la disponibilité des produits et leurs localisations.
- **Accessibilité accrue** : Un appui vital pour les patients vulnérables ou vivant dans des zones reculées.

#### Pour les Pharmacies
- **Flux accru de clients** : Une présence visible auprès de nombreux utilisateurs.
- **Amélioration de la gestion des stocks** : Réduction des pertes et meilleure rotation des produits.
- **Satisfaction client** : Une expérience fluide qui favorise la fidélisation.

#### Pour le Système de Santé
- **Réduction des ruptures de stock** : Une meilleure gestion globale de la chaîne d'approvisionnement.
- **Augmentation de l'observance des traitements** : Les patients accèdent plus facilement à leurs médicaments.
- **Optimisation des ressources** : Une utilisation plus efficace des infrastructures pharmaceutiques.

### Impact Social et Économique

MonMedicament est bien plus qu'une simple plateforme. Elle représente un vecteur de transformation pour les communautés africaines :
- **Accès amélioré aux soins** : Une meilleure santé pour tous, quel que soit leur emplacement ou leur condition physique.
- **Réduction des déchets pharmaceutiques** : En optimisant la gestion des stocks, nous minimisons les médicaments inutilisés.
- **Inclusion sociale** : Un outil adapté aux besoins des personnes à mobilité réduite ou à faible revenu.
- **Création d'emplois** : L'écosystème MonMedicament soutient de nouveaux emplois dans les technologies et la logistique.

### Plan d'Action et Prochaines Étapes

1. **Développement de la plateforme** : Lancement d'une application intuitive et ergonomique pour les utilisateurs et les pharmacies.
2. **Partenariats stratégiques** : Collaboration avec des pharmacies, hôpitaux et autorités de santé locales.
3. **Phase pilote** : Mise en place d'un projet pilote dans une ou deux grandes villes pour tester et affiner la solution.
4. **Expansion régionale** : Déploiement progressif dans d'autres régions et pays africains.
5. **Sensibilisation et éducation** : Campagnes pour informer le public et les professionnels de santé sur les avantages de MonMedicament.

### Conclusion

MonMedicament n'est pas seulement une plateforme technologique, mais une solution humaine pour un problème pressant. En connectant efficacement les patients, les pharmacies et le système de santé, nous transformons l'accès aux médicaments en Afrique. Rejoignez-nous dans cette révolution pour une santé plus accessible, plus rapide et plus efficace.

### **Stack Technique pour PharmLocator (MVP)**

#### **1. Backend : Laravel**
- **Pourquoi Laravel ?**
  - Framework PHP moderne, facile à apprendre et à utiliser.
  - Architecture MVC (Modèle-Vue-Contrôleur) pour une séparation claire des responsabilités.
  - Intègre des fonctionnalités clés comme l'authentification, la gestion des routes, les migrations de base de données, etc.
  - Communauté active et documentation complète.
- **Fonctionnalités clés à utiliser :**
  - **Eloquent ORM** : Pour la gestion des bases de données (interactions avec les tables pharmacies, médicaments, utilisateurs, etc.).
  - **API RESTful** : Pour permettre une communication fluide entre le frontend et le backend.
  - **Authentification** : Gestion des utilisateurs (patients, pharmacies, administrateurs).
  - **File Storage** : Pour gérer les uploads d'ordonnances ou d'images.
  - **Notifications** : Envoi de notifications par email ou SMS (pour les alertes de disponibilité de médicaments).

---

#### **2. Base de Données : MySQL**
- **Pourquoi MySQL ?**
  - Base de données relationnelle fiable et largement utilisée.
  - Intégration facile avec Laravel via Eloquent ORM.
  - Idéale pour gérer les relations entre les tables (pharmacies, médicaments, stocks, utilisateurs, etc.).
- **Tables principales :**
  - **Utilisateurs** : Patients, pharmacies, administrateurs.
  - **Pharmacies** : Informations sur les pharmacies (nom, adresse, coordonnées, etc.).
  - **Médicaments** : Liste des médicaments disponibles.
  - **Stocks** : Association entre les pharmacies et les médicaments (quantités disponibles).
  - **Ordonnances** : Gestion des ordonnances uploadées par les patients.

---

#### **3. Frontend : Blade (Templating Laravel) + Tailwind CSS**
- **Pourquoi Blade et Tailwind CSS ?**
  - **Blade** : Système de templating intégré à Laravel, simple et performant pour générer des vues dynamiques.
  - **Tailwind CSS** : Framework CSS utilitaire pour créer des interfaces modernes et réactives rapidement.
- **Fonctionnalités clés :**
  - Formulaire de recherche de médicaments.
  - Affichage des résultats (liste des pharmacies avec les médicaments disponibles).
  - Pages de profil pour les patients et les pharmacies.
  - Interface d'administration pour gérer les données.

---

#### **4. Authentification : Laravel Breeze ou Jetstream**
- **Pourquoi ?**
  - **Laravel Breeze** : Solution légère pour l'authentification (connexion, inscription, réinitialisation de mot de passe).
  - **Laravel Jetstream** : Solution plus complète avec gestion des équipes, authentification à deux facteurs, etc.
- **Cas d'utilisation :**
  - Authentification des patients et des pharmacies.
  - Gestion des rôles (patient, pharmacie, administrateur).

---

#### **5. API : Laravel Sanctum ou Passport**
- **Pourquoi ?**
  - **Sanctum** : Pour une authentification légère et sécurisée via des tokens (idéal pour les applications SPA ou mobiles futures).
  - **Passport** : Pour une gestion plus avancée des OAuth2 (si vous prévoyez une intégration avec d'autres services).
- **Cas d'utilisation :**
  - Communication entre le frontend et le backend.
  - Préparation pour une future application mobile.

---

#### **6. Recherche et Filtres : Laravel Scout + Algolia ou Meilisearch**
- **Pourquoi ?**
  - **Laravel Scout** : Pour intégrer une recherche full-text performante.
  - **Algolia** ou **Meilisearch** : Pour une recherche rapide et précise des médicaments et pharmacies.
- **Cas d'utilisation :**
  - Recherche de médicaments par nom.
  - Filtrage des pharmacies par localisation, disponibilité de stock, etc.

---

#### **7. Géolocalisation : Google Maps API ou OpenStreetMap**
- **Pourquoi ?**
  - **Google Maps API** : Pour afficher les pharmacies sur une carte et calculer les distances.
  - **OpenStreetMap** : Alternative open source pour la géolocalisation.
- **Cas d'utilisation :**
  - Affichage des pharmacies sur une carte.
  - Calcul des itinéraires pour les patients.

---

#### **8. Notifications : Laravel Notifications**
- **Pourquoi ?**
  - Permet d'envoyer des notifications par email, SMS (via des services comme Twilio) ou notifications push.
- **Cas d'utilisation :**
  - Alertes de disponibilité de médicaments.
  - Confirmation de commande ou de réservation.

---

### **Avantages de ce Stack**
- **Rapidité de développement** : Laravel permet de créer des fonctionnalités rapidement.
- **Scalabilité** : Le stack est conçu pour évoluer avec l'application.
- **Flexibilité** : Possibilité d'ajouter des fonctionnalités (comme une app mobile) via l'API.
- **Coût réduit** : Utilisation de technologies open source et hébergement abordable.

---

### Typographie et Palette de Couleurs

#### **Typographie**
- Utilisons **Google Fonts** pour une intégration simple et rapide.  
  - **Titre** : [Poppins](https://fonts.google.com/specimen/Poppins) (moderne, lisible, et professionnel).  
  - **Texte** : [Roboto](https://fonts.google.com/specimen/Roboto) (sobre et lisible pour les paragraphes).

#### **Palette de Couleurs**
Inspirons-nous d'une ambiance professionnelle et apaisante, en utilisant des tons médicaux (bleu et vert), avec des couleurs secondaires pour mettre en évidence certaines actions.

| Couleur            | Usage                 | Code Hex |
|---------------------|-----------------------|----------|
| **Bleu primaire**   | Fond, boutons, liens | `#007BFF` |
| **Vert secondaire** | Validation, accents  | `#28A745` |
| **Gris clair**      | Fonds neutres        | `#F8F9FA` |
| **Blanc**           | Texte sur fond coloré | `#FFFFFF` |
| **Rouge**           | Erreurs ou alertes   | `#DC3545` |

#### **2. Interface Patient**

##### **2.1. Recherche de Médicaments**
- **Objectif** : Permettre au patient de rechercher un médicament.
- **Éléments clés** :
  - Champ de recherche : Saisir le nom du médicament.
  - Bouton "Rechercher".
  - Option : "Scanner une ordonnance" (pour les futurs développements).

##### **2.2. Résultats de Recherche**
- **Objectif** : Afficher les pharmacies ayant le médicament en stock.
- **Éléments clés** :
  - Liste des pharmacies avec :
    - Nom de la pharmacie.
    - Adresse.
    - Distance par rapport au patient.
    - Quantité disponible.
  - Bouton "Voir sur la carte" (optionnel pour MVP).
  - Bouton "Contacter la pharmacie" (redirige vers les détails de la pharmacie).

##### **2.3. Détails de la Pharmacie**
- **Objectif** : Afficher les informations détaillées de la pharmacie sélectionnée.
- **Éléments clés** :
  - Nom et logo de la pharmacie.
  - Adresse complète.
  - Numéro de téléphone.
  - Heures d'ouverture.
  - Bouton "Itinéraire" (intégration Google Maps ou OpenStreetMap).
  - Bouton "Contacter" (option pour appeler ou envoyer un message).

---

#### **3. Interface Pharmacie**

##### **3.1. Connexion/Inscription**
- **Objectif** : Permettre aux pharmacies de se connecter ou de s'inscrire.
- **Éléments clés** :
  - Formulaire de connexion (email + mot de passe).
  - Lien "Créer un compte" (redirige vers l'inscription).
  - Formulaire d'inscription :
    - Nom de la pharmacie.
    - Adresse.
    - Email.
    - Mot de passe.

##### **3.2. Tableau de Bord Pharmacie**
- **Objectif** : Permettre à la pharmacie de gérer son stock et ses informations.
- **Éléments clés** :
  - Vue d'ensemble du stock (médicaments disponibles, quantités).
  - Bouton "Ajouter un médicament" (pour mettre à jour le stock).
  - Liste des médicaments avec :
    - Nom du médicament.
    - Quantité en stock.
    - Bouton "Modifier" ou "Supprimer".
  - Section "Informations de la pharmacie" (modifiable).

##### **3.3. Ajout/Modification de Stock**
- **Objectif** : Permettre à la pharmacie d'ajouter ou de modifier des médicaments dans son stock.
- **Éléments clés** :
  - Formulaire :
    - Nom du médicament.
    - Quantité disponible.
    - Prix (optionnel pour MVP).
  - Bouton "Enregistrer".

---

#### **4. Authentification Utilisateur**

##### **4.1. Connexion Patient**
- **Objectif** : Permettre aux patients de se connecter pour accéder à des fonctionnalités supplémentaires (historique de recherche, favoris, etc.).
- **Éléments clés** :
  - Formulaire de connexion (email + mot de passe).
  - Lien "Créer un compte" (redirige vers l'inscription).

##### **4.2. Inscription Patient**
- **Objectif** : Permettre aux patients de créer un compte.
- **Éléments clés** :
  - Formulaire d'inscription :
    - Nom.
    - Email.
    - Mot de passe.
    - Confirmation du mot de passe.

---


-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    user_type ENUM('PATIENT', 'PHARMACY', 'ADMIN') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user_email (email),
    INDEX idx_user_type (user_type)
);

-- Table des pharmacies
CREATE TABLE pharmacies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    opening_hour TIME NOT NULL,
    closing_hour TIME NOT NULL,
    is_open_weekends BOOLEAN DEFAULT FALSE,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_pharmacy_location (latitude, longitude),
    INDEX idx_pharmacy_name (name)
);

-- Table des médicaments
CREATE TABLE medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    generic_name VARCHAR(100),
    manufacturer VARCHAR(100),
    description TEXT,
    category ENUM('ANTIBIOTICS', 'PAINKILLERS', 'ANTIVIRALS', 'VITAMINS', 'OTHER') NOT NULL DEFAULT 'OTHER',
    requires_prescription BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_medicine_name (name),
    INDEX idx_medicine_generic (generic_name),
    INDEX idx_medicine_category (category)
);

-- Table d'inventaire des pharmacies
CREATE TABLE pharmacy_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pharmacy_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity_available INT NOT NULL DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    expiry_date DATE,
    in_stock BOOLEAN DEFAULT TRUE,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pharmacy_id) REFERENCES pharmacies(id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pharmacy_medicine (pharmacy_id, medicine_id),
    INDEX idx_inventory_availability (in_stock, quantity_available)
);

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pharmacy_id INT NOT NULL,
    reservation_date DATETIME NOT NULL,
    status ENUM('PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED') NOT NULL DEFAULT 'PENDING',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pharmacy_id) REFERENCES pharmacies(id) ON DELETE CASCADE,
    INDEX idx_reservation_status (status),
    INDEX idx_reservation_date (reservation_date)
);

-- Table des items de réservation
CREATE TABLE reservation_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_reservation_medicine (reservation_id, medicine_id)
);
