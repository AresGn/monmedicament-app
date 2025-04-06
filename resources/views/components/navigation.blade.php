<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="fas fa-pills me-2 text-primary"></i>
            {{ config('app.name', 'MonMédicament') }}
        </a>
        
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('patient.home') }}#how-it-works">
                        <i class="fas fa-info-circle me-2 d-md-none"></i>
                        Comment ça marche
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ url('/patient/pharmacies') }}">
                        <i class="fas fa-store me-2 d-md-none"></i>
                        Pharmacies
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ url('/contact') }}">
                        <i class="fas fa-envelope me-2 d-md-none"></i>
                        Contact
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ url('/about') }}">
                        <i class="fas fa-question-circle me-2 d-md-none"></i>
                        À propos
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav auth-buttons">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item me-md-2 mb-2 mb-md-0">
                        <a class="btn btn-outline-primary w-100" href="{{ route('patient.search.index') }}">
                            <i class="fas fa-search me-2"></i>
                            Voir une démo
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="btn btn-primary w-100" href="{{ route('patient.auth.login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ Auth::user()->user_type === 'PATIENT' ? route('patient.profile.edit') : route('pharmacy.profile.edit') }}" title="Mon compte">
                            <i class="fas fa-user me-2"></i>
                            <span class="d-md-none">Mon compte</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Déconnexion">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span class="d-md-none">Déconnexion</span>
                        </a>
                        
                        <form id="logout-form" action="{{ route('patient.auth.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Ajouter le backdrop pour le menu mobile -->
<div class="navbar-backdrop"></div>

<style>
/* Styles de base de la navbar */
.navbar {
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
}

.navbar-brand {
    font-weight: 600;
    font-size: 1.25rem;
    color: #0D6EFD;
}

/* Style personnalisé pour le toggler */
.custom-toggler {
    border: none;
    padding: 0;
    width: 40px;
    height: 40px;
    position: relative;
    background: transparent;
}

.hamburger-icon {
    width: 24px;
    height: 20px;
    position: relative;
    margin: 0 auto;
    transform: rotate(0deg);
    transition: .5s ease-in-out;
}

.hamburger-icon span {
    display: block;
    position: absolute;
    height: 3px;
    width: 100%;
    background: #0D6EFD;
    border-radius: 3px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: .25s ease-in-out;
}

.hamburger-icon span:nth-child(1) {
    top: 0px;
}

.hamburger-icon span:nth-child(2) {
    top: 8px;
}

.hamburger-icon span:nth-child(3) {
    top: 16px;
}

/* Animation du hamburger */
.navbar-toggler[aria-expanded="true"] .hamburger-icon span:nth-child(1) {
    top: 8px;
    transform: rotate(135deg);
}

.navbar-toggler[aria-expanded="true"] .hamburger-icon span:nth-child(2) {
    opacity: 0;
    left: -60px;
}

.navbar-toggler[aria-expanded="true"] .hamburger-icon span:nth-child(3) {
    top: 8px;
    transform: rotate(-135deg);
}

/* Styles des liens de navigation */
.nav-link {
    color: #333;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #0D6EFD;
}

/* Styles pour mobile */
@media (max-width: 767.98px) {
    .navbar-collapse {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 80%;
        max-width: 320px;
        background: white;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        display: block !important;
        margin: 0;
        padding: 1rem;
        z-index: 1040;
        overflow-y: auto;
    }

    .navbar-collapse.show {
        transform: translateX(0);
    }

    .navbar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 1030;
    }

    .navbar-backdrop.show {
        opacity: 1;
        visibility: visible;
    }

    .navbar-nav {
        padding: 1rem 0;
    }

    .nav-item {
        margin: 0.5rem 0;
    }

    .nav-link {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }

    .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .auth-buttons {
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        font-size: 1.1rem;
    }

    /* Style du header du menu mobile */
    .mobile-menu-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .mobile-menu-title {
        font-weight: 600;
        color: #0D6EFD;
        font-size: 1.1rem;
    }

    .mobile-menu-close {
        background: none;
        border: none;
        color: #666;
        padding: 0.5rem;
        cursor: pointer;
        font-size: 1.25rem;
    }
}

/* Animation de la navbar au scroll */
.navbar.scrolled {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Styles des boutons */
.btn {
    padding: 0.5rem 1rem;
    font-weight: 500;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
}

.btn-outline-primary {
    border-color: #0D6EFD;
    color: #0D6EFD;
}

.btn-outline-primary:hover {
    background-color: #0D6EFD;
    color: white;
    transform: translateY(-1px);
}

.btn-primary {
    background-color: #0D6EFD;
    border-color: #0D6EFD;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation de la navbar au scroll
    const navbar = document.querySelector('.navbar');
    const backdrop = document.querySelector('.navbar-backdrop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Gestion du menu mobile
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        // Ajouter le header du menu mobile
        const mobileHeader = document.createElement('div');
        mobileHeader.className = 'mobile-menu-header d-md-none';
        mobileHeader.innerHTML = `
            <span class="mobile-menu-title">Menu</span>
            <button class="mobile-menu-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        navbarCollapse.insertBefore(mobileHeader, navbarCollapse.firstChild);

        // Gérer la fermeture du menu
        const closeMenu = () => {
            navbarToggler.classList.remove('active');
            navbarToggler.setAttribute('aria-expanded', 'false');
            navbarCollapse.classList.remove('show');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        };

        // Gérer l'ouverture du menu
        const openMenu = () => {
            navbarToggler.classList.add('active');
            navbarToggler.setAttribute('aria-expanded', 'true');
            navbarCollapse.classList.add('show');
            backdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        };

        // Event listeners
        navbarToggler.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Fermer le menu au clic sur le backdrop
        backdrop.addEventListener('click', closeMenu);

        // Fermer le menu au clic sur le bouton de fermeture
        const closeButton = document.querySelector('.mobile-menu-close');
        if (closeButton) {
            closeButton.addEventListener('click', closeMenu);
        }

        // Fermer le menu au clic sur un lien
        const navLinks = navbarCollapse.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeMenu();
                }
            });
        });

        // Gérer le redimensionnement de la fenêtre
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeMenu();
                navbarCollapse.style.transform = '';
            }
        });

        // Empêcher la propagation des clics dans le menu
        navbarCollapse.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
});
</script> 