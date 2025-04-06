require('./bootstrap');

// Mobile Menu Animation
document.addEventListener('DOMContentLoaded', function() {
    // Animation du menu mobile lorsqu'il s'ouvre
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Ajouter une classe pour déclencher l'animation
            setTimeout(function() {
                if (navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.add('show-animated');
                } else {
                    navbarCollapse.classList.remove('show-animated');
                }
            }, 50);
        });
    }
    
    // Initialisation du slider de témoignages s'il existe
    initTestimonialSlider();
});

// Fonction pour initialiser le slider de témoignages
function initTestimonialSlider() {
    const slider = document.querySelector('.testimonial-slider');
    if (!slider) return;

    const track = slider.querySelector('.testimonial-track');
    const slides = slider.querySelectorAll('.testimonial-slide');
    const dotsContainer = slider.querySelector('.testimonial-nav');
    const slideCount = slides.length;
    let currentIndex = 0;
    let autoplayInterval;

    // Créer les points de navigation
    if (dotsContainer) {
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('div');
            dot.classList.add('testimonial-dot');
            if (i === 0) dot.classList.add('active');
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                goToSlide(i);
                resetAutoplay();
            });
            dotsContainer.appendChild(dot);
        }
    }

    // Fonction pour aller à un slide spécifique
    function goToSlide(index) {
        if (track) {
            currentIndex = index;
            track.style.transform = `translateX(-${index * 100}%)`;
            
            // Mettre à jour les points actifs
            if (dotsContainer) {
                const dots = dotsContainer.querySelectorAll('.testimonial-dot');
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }
        }
    }

    // Fonction pour passer au slide suivant
    function nextSlide() {
        let nextIndex = currentIndex + 1;
        if (nextIndex >= slideCount) {
            nextIndex = 0;
        }
        goToSlide(nextIndex);
    }

    // Fonction pour redémarrer l'autoplay
    function resetAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
        }
        autoplayInterval = setInterval(nextSlide, 5000);
    }

    // Lancer l'autoplay
    resetAutoplay();
}
